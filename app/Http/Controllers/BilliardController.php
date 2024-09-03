<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Meja;
use App\Models\NonMember;
use App\Models\Rental;
use App\Models\Member;
use App\Models\RentalInvoice;
use App\Models\Invoice;
use App\Models\HargaRental;
use App\Models\Order;
use App\Models\Paket;

use DateTime;
use DateInterval;
use Carbon\Carbon;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

class BilliardController extends Controller
{
    public function print2()
    {
        return view('invoice.struk');

        // Fetching the receipt text from the request
        // $receiptText = "Hello World";

        // if (empty($receiptText)) {
        //     return response()->json(['success' => false, 'error' => 'Receipt text cannot be empty.']);
        // }

        // try {
        //     $printerName = "POS-58";
        //     $connector = new WindowsPrintConnector($printerName);
        //     $printer = new Printer($connector);
        //     $printer->text($receiptText);
        //     $printer->cut();
        //     $printer->close();

        //     return response()->json(['success' => true, 'message' => 'Receipt printed successfully!']);
        // } catch (\Exception $e) {
        //     // Log the full error message
        //     \Log::error('Failed to print receipt: ', ['exception' => $e->getMessage()]);
        //     return response()->json(['success' => false, 'error' => 'Failed to print receipt: ' . $e->getMessage()]);
        // }
    }

    public function print($id_rental)
    {
        
        $meja_rental = RentalInvoice::where('id_rental', $id_rental)->first();
        $meja_rental2 = RentalInvoice::where('id_rental', $id_rental)->get();
        $rental = RentalInvoice::where('id_rental', $id_rental)->count();
        $no_meja = $meja_rental->no_meja;
        if ($meja_rental) {
            $makanan = Order::where('id_table', $meja_rental->id)
                            ->where('status','sudah')
                            ->with('items')->get();

            $idplayer = substr($meja_rental->id_player, 0, 1);

            if ($idplayer == 'M') {
                $mejatotal = 0;
                $lama_waktu = 0;
            } else {
                $hargarental = HargaRental::where('jenis', 'menit')->first();
                $lama_waktu = $meja_rental->first()->lama_waktu;

                if (!$lama_waktu) {
                    $elapsedSeconds = request()->query('elapsed');

                    if ($elapsedSeconds !== null) {
                        $hours = floor($elapsedSeconds / 3600);
                        $minutes = floor(($elapsedSeconds % 3600) / 60);
                        $seconds = $elapsedSeconds % 60;

                        $lama_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                    } else {
                        $lama_waktu = '00:00:00';
                    }
                }

                list($hours, $minutes, $seconds) = sscanf($lama_waktu, '%d:%d:%d');
                $total_minutes = $hours * 60 + $minutes + $seconds / 60;

                $harga_per_menit = $hargarental ? $hargarental->harga : 0;
                $mejatotal = $total_minutes * $harga_per_menit;
            }

            $total_makanan = $makanan->flatMap(function($order) {
                return $order->items;
            })->sum(function($item) {
                return (float) $item->price;
            });
        
            // Total biaya keseluruhan
            // $total = $mejatotal + $total_makanan;
            // $total = round($total); 
            $total = $makanan->flatMap(function($order) {
                return $order->items;
            })->sum(function($item) {
                return $item->price * $item->quantity;
            });
            
            $total += $mejatotal; // If `mejatotal` is to be included in the total
            
            return view('invoice.struk', compact('meja_rental','meja_rental2', 'no_meja', 'rental', 'lama_waktu', 'mejatotal', 'total', 'makanan'));
        } else {
            return redirect()->back()->with('error', 'No rental found for the specified table.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meja = Meja::all();
        $rental = Rental::all();
    
        $meja_rental = $meja->map(function($m) use ($rental) {
            $invoice = $rental->firstWhere('no_meja', $m->nomor);
            return [
                'nomor_meja' => $m->nomor,
                'waktu_akhir' => $invoice && $invoice->waktu_akhir ? $invoice->waktu_akhir->format('Y-m-d H:i:s') : null,
                'status' => $invoice ? $invoice->status : null // Tambahkan status
            ];
        });
    
        return view('billiard.index', compact('meja_rental'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('billiard.nonmember');
    }

    public function menu($no_meja)
    {
        //
        return view('billiard.menu', ['no_meja' => $no_meja]);

        // return view('billiard.menu');
    }

    public function nonmember($no_meja)
    {
        //
        return view('billiard.nonmember', ['no_meja' => $no_meja]);
    }

    public function stop($no_meja)
{
    $meja_rental = Rental::where('no_meja', $no_meja)->first();
    $meja_rental2 = Rental::where('no_meja', $no_meja)->get();
    $rental = Rental::where('no_meja', $no_meja)->count();
    
    if ($meja_rental) {
        $makanan = Order::where('id_table', $meja_rental->id)
                        ->where('status', 'belum')
                        ->with('items')->get();

        $idplayer = substr($meja_rental->id_player, 0, 1);

        if ($idplayer == 'M') {
            $mejatotal = 0;
            $lama_waktu = '00:00:00';
        } else {
            $hargarental = HargaRental::where('jenis', 'menit')->first();
            $lama_waktu = $meja_rental->lama_waktu ?? '00:00:00'; // Safely access 'lama_waktu' with a default

            if (!$lama_waktu || $lama_waktu == '00:00:00') {
                $elapsedSeconds = request()->query('elapsed');

                if ($elapsedSeconds !== null) {
                    $hours = floor($elapsedSeconds / 3600);
                    $minutes = floor(($elapsedSeconds % 3600) / 60);
                    $seconds = $elapsedSeconds % 60;

                    $lama_waktu = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                }
            }

            list($hours, $minutes, $seconds) = sscanf($lama_waktu, '%d:%d:%d');
            $total_minutes = $hours * 60 + $minutes + $seconds / 60;

            // Initialize default per-minute pricing
            $harga_per_menit = $hargarental ? $hargarental->harga : 0;
            $mejatotal = $total_minutes * $harga_per_menit;

            // Iterate through the packages to find the best pricing
            $paket = Paket::all();
            foreach ($paket as $p) {
                if ($lama_waktu >= $p->jam) {
                    // Set mejatotal to the package price if the package applies
                    $mejatotal = $p->harga;
                }
            }
        }

        $total_makanan = $makanan->flatMap(function ($order) {
            return $order->items;
        })->sum(function ($item) {
            return (float) $item->price;
        });

        // Total biaya keseluruhan
        $total = $mejatotal + $total_makanan;
        $total = round($total);
        return view('invoice.stop', compact('meja_rental', 'meja_rental2', 'no_meja', 'rental', 'lama_waktu', 'mejatotal', 'total', 'makanan'));
    } else {
        return redirect()->back()->with('error', 'No rental found for the specified table.');
    }
}


    public function bayar(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'no_meja' => 'required|string',
            'lama_waktu' => 'required|string'
        ]);

        try {
            // Ambil data meja rental berdasarkan no_meja
            $meja_rental = Rental::where('no_meja', $validated['no_meja'])->firstOrFail();

            // Cek dan siapkan variabel
            $lama_waktu = $validated['lama_waktu'];
            $waktu_mulai = $meja_rental->waktu_mulai;
            $waktu_akhir = $meja_rental->waktu_akhir;
            $no_meja = $meja_rental->no_meja;
            $id_player = $meja_rental->id_player;

            // Generasikan id_rental unik
            do {
                $id_rental = 'R' . rand(1, 1000000000);
            } while (RentalInvoice::where('id_rental', $id_rental)->exists());

            // Simpan data RentalInvoice
            RentalInvoice::create([
                'id_rental' => $id_rental,
                'lama_waktu' => $lama_waktu,
                'waktu_mulai' => $waktu_mulai,
                'waktu_akhir' => $waktu_akhir,
                'no_meja' => $no_meja
            ]);

            // Update status 
            if (Order::where('id_table', $meja_rental->id)->exists()) {
                $orders = Order::where('id_table', $meja_rental->id)->where('status', 'belum')->get();
                foreach ($orders as $order) {
                    $order->update(['status' => 'lunas']);
                }
                $orderss = $orders->first()->id_table;
            } else {
                $orderss = 0;
            }

            // Simpan data Invoice
            Invoice::create([
                'id_player' => $id_player,
                'id_rental' => $id_rental,
                'id_belanja' => $orderss
            ]);

            // Hapus data meja rental
            $meja_rental->delete();

            // Kembalikan respons sukses dengan no_meja
            return response()->json(['success' => true, 'id_rental' => $id_rental]);

        } catch (\Exception $e) {
            // Tangkap dan log kesalahan
            \Log::error('Error in bayar function:', ['error' => $e->getMessage(), 'id_rental' => $id_rental]);
            return response()->json(['success' => false, 'error' => 'There was an error processing your request.'], 500);
        }
    }

    
    public function storemember(Request $request)
    {
        //
        if (!preg_match('/^\d{2}:\d{2}$/', $request->lama_waktu)) {
            return response()->json(['error' => 'Invalid time format'], 400);
        }
    
        // Mengambil waktu saat ini di timezone Jakarta
        $tanggalMain = Carbon::now('Asia/Jakarta');
        $lamaWaktu = $request->lama_waktu;
    
        // Memisahkan lamaWaktu menjadi hours dan minutes
        list($hours, $minutes) = explode(':', $lamaWaktu);
        $intervalString = 'PT' . $hours . 'H' . $minutes . 'M';
        $interval = new \DateInterval($intervalString);
    
        // Menambahkan interval ke tanggalMain
        $tanggalMain->add($interval);
        $waktuAkhir = $tanggalMain->format('Y-m-d H:i:s');

        // $member = Member::where('id_member',$request->nama);
        // return $request->nama;
        
        $b = Rental::create([
            'id_player' => $request->nama,
            'lama_waktu' => $request->lama_waktu,
            'waktu_mulai' => now(),
            'waktu_akhir' => $waktuAkhir,
            'no_meja' => $request->no_meja
        ]);
        return redirect()->route('bl.index');
    }
    public function storemember2(Request $request)
    {
        // Mengambil waktu saat ini di timezone Jakarta
        $tanggalMain = Carbon::now('Asia/Jakarta');

        $b = Rental::create([
            'id_player' => $request->nama,
            'waktu_mulai' => $tanggalMain,
            'no_meja' => $request->no_meja,
            'status' => 'lanjut'
        ]);
        return redirect()->route('bl.index');
    }
    public function menumember($no_meja)
    {
        //
        $member = Member::all();
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.menumember', compact('meja_rental', 'no_meja', 'member'));
    }
    public function memberlanjutan($no_meja)
    {
        //
        $member = Member::all();
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.memberlanjutan', compact('meja_rental', 'no_meja', 'member'));
    }
    public function memberperwaktu($no_meja)
    {
        //
        $member = Member::all();
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.memberperwaktu', compact('meja_rental', 'no_meja', 'member'));
    }

    public function storenonmember(Request $request)//lanjutan
    {
        //
        $id_non = rand(1,1000000000);
        $tanggalMain = Carbon::now('Asia/Jakarta');
        $a = NonMember::create([
            'id' => $id_non,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp
        ]);
        $b = Rental::create([
            'id_player' => $id_non,
            'waktu_mulai' => $tanggalMain,
            'no_meja' => $request->no_meja,
            'status' => 'lanjut'
        ]);
        return redirect()->route('bl.index');
    }
    public function storenonmember2(Request $request)//perwaktu
    {
        $id_non = rand(1,1000000000);

        if (!preg_match('/^\d{2}:\d{2}$/', $request->lama_waktu)) {
            return response()->json(['error' => 'Invalid time format'], 400);
        }
    
        // Mengambil waktu saat ini di timezone Jakarta
        $tanggalMain = Carbon::now('Asia/Jakarta');
        $lamaWaktu = $request->lama_waktu;
        list($hours, $minutes) = explode(':', $lamaWaktu);
        $intervalString = 'PT' . $hours . 'H' . $minutes . 'M';

        $interval = new DateInterval($intervalString);
        $tanggalMain->add($interval);
        $waktuAkhir = $tanggalMain->format('Y-m-d H:i:s');

        $a = NonMember::create([
            'id' => $id_non,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp
        ]);
        $b = Rental::create([
            'id_player' => $id_non,
            'lama_waktu' => $request->lama_waktu,
            'waktu_mulai' => now(),
            'waktu_akhir' => $waktuAkhir,
            'no_meja' => $request->no_meja
        ]);
        return redirect()->route('bl.index');
    }
    public function menunonmember($no_meja)
    {
        //
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.menunonmember', compact('meja_rental', 'no_meja'));
    }
    public function nonmemberlanjutan($no_meja)
    {
        //
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.nonmemberlanjutan', compact('meja_rental', 'no_meja'));
    }
    public function nonmemberperwaktu($no_meja)
    {
        //
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.nonmemberperwaktu', compact('meja_rental', 'no_meja'));
    }

    public function rekapinvoice()
    {
        // with('order.items')->
        $invoices = Invoice::with('rentalinvoice')->get();
        // return $invoices;
        return view('billiard.rekap',compact('invoices'));
    }

    public function showrekap(string $id)
    {
        $query = "
            SELECT 
                i.id AS invoice_id, 
                i.id_player, 
                i.id_rental, 
                i.id_belanja, 
                o.id AS order_id, 
                o.id_table, 
                o.status AS order_status, 
                oi.id AS item_id, 
                oi.product_name, 
                oi.quantity, 
                oi.price,
                ri.lama_waktu,
                ri.waktu_mulai,
                ri.waktu_akhir,
                ri.no_meja
            FROM 
                invoice AS i
            LEFT JOIN 
                `orders` AS o ON i.id_belanja = o.id_table
            LEFT JOIN 
                order_items AS oi ON o.id = oi.order_id
            JOIN
                rental_invoice AS ri ON i.id_rental = ri.id_rental
            WHERE
                i.id = :id
        ";

        $invoices = DB::select($query, ['id' => $id]);

        return view('billiard.showrekap',compact('invoices'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
