<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use App\Models\NonMember;
use App\Models\Rental;
use App\Models\Member;
use App\Models\RentalInvoice;
use App\Models\Invoice;

use DateTime;
use DateInterval;
use Carbon\Carbon;

class BilliardController extends Controller
{
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
                'waktu_akhir' => $invoice ? $invoice->waktu_akhir->format('Y-m-d H:i:s') : null
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

    public function member($no_meja)
    {
        //
        $member = Member::all();
        $meja_rental = Rental::where('no_meja', $no_meja)->get();

        return view('billiard.member', compact('meja_rental', 'no_meja', 'member'));
    }

    public function stop($no_meja)
    {
        $meja_rental = Rental::where('no_meja', $no_meja)->get();
        $rental = Rental::where('no_meja',$no_meja)->count();
        
        return view('invoice.stop', compact('meja_rental', 'no_meja', 'rental'));
    }

    public function bayar(Request $request)
    {
        $meja_rental = Rental::where('no_meja', $request->bayar)->get();
        foreach ($meja_rental as $rental) {
            $lama_waktu = $rental->lama_waktu;
            $waktu_mulai = $rental->waktu_mulai;
            $waktu_akhir = $rental->waktu_akhir;
            $no_meja = $rental->no_meja;
            $id_player = $rental->id_player;
        }

        do {
            $id_rental = 'R' . rand(1,1000000000);
        } while (RentalInvoice::where('id_rental', $id_rental)->exists());

        $a = RentalInvoice::create([
            'id_rental' => $id_rental,
            'lama_waktu' => $lama_waktu,
            'waktu_mulai' => $waktu_mulai,
            'waktu_akhir' => $waktu_akhir,
            'no_meja' => $no_meja
        ]);

        $b = Invoice::create([
            'id_player' => $id_player,
            'id_rental' => $id_rental
        ]);

        $meja_rental->each->delete();

        return redirect()->route('bl.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $id_non = rand(1,1000000000);

        $tanggalMain = now();
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

    public function storemember(Request $request)
    {
        //
        $tanggalMain = now();
        $lamaWaktu = $request->lama_waktu;
        list($hours, $minutes) = explode(':', $lamaWaktu);
        $intervalString = 'PT' . $hours . 'H' . $minutes . 'M';
        $interval = new DateInterval($intervalString);
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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
