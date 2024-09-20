<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_table' => 'integer',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Buat order
        Log::info('Order created', ['order_id' => $request->id_table]);

        $order = Order::create([
            'id_table' => $request->id_table,
            'status' => 'lunas'
        ]);

        // Tambahkan items ke order dan kurangi stok produk
        foreach ($request->items as $item) {
            // Buat order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'metode' => "langsung"
            ]);

            // Kurangi stok produk berdasarkan nama produk
            $produk = Produk::where('nama_produk', $item['name'])->first();
            if ($produk) {
                // Log jumlah stok sebelum dikurangi
                Log::info('Initial product quantity', ['product' => $produk->nama_produk, 'qty' => $produk->qty]);

                // Kurangi stok
                $produk->qty -= $item['quantity'];
                $produk->save();

                // Log jumlah stok setelah dikurangi
                Log::info('Updated product quantity', ['product' => $produk->nama_produk, 'qty' => $produk->qty]);
            } else {
                // Log jika produk tidak ditemukan
                Log::error('Product not found', ['product' => $item['name']]);
            }
        }

        Invoice::create([
            'id_belanja' => $request->id_table,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['success' => true, "order_id"=>$order->id]);
    }


    public function store2(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_table' => 'integer',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
        // Buat order
        Log::info('Order created', ['order_id' => $request]);

        // Buat order
        $order = Order::create([
            'id_table' => $request->id_table,
            'status' => "belum"
        ]);
        // Tambahkan items ke order
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'metode' => "simpan"
            ]);
        }

        

        return response()->json(['success' => true]);
    }

    public function struk($order_id){
        // return $order_id;
        $orderid = OrderItem::where('order_id', $order_id)->first();

        $order = OrderItem::where('order_id', $order_id)->get();
        // return $order;
        $makanan = Order::where('id', $order_id) // Use `no_meja` or the correct reference
                            ->where('status', 'lunas')
                            ->with('items') // Eager load items
                            ->get();
        // Calculate the total for all food items
        $total_makanan = $makanan->flatMap(function($order) {
            return $order->items;
        })->sum(function($item) {
            return $item->price * $item->quantity;
        });

        // Total biaya keseluruhan
        $total = $total_makanan;
        $total = round($total);
        return view("invoice.struk-order", compact("order","orderid","makanan","total"));
    }

    public function rekap(){
        // Retrieve all order items
        $orderItems = OrderItem::all();
    
        // Extract the order IDs from the order items
        $orderIds = $orderItems->pluck('order_id')->toArray();
    
        // Retrieve orders where status is 'lunas' and the order_id matches those in order items
        $orders = Order::where("status", "lunas")
        ->whereIn("id", $orderIds)
        ->with('items') // Eager load the items relationship
        ->get();
        $summarizedOrders = [];
        $accountid = Invoice::where("id_belanja",$orderIds)->get();
        return $accountid;
                       // Loop through each order and sum the prices of items with the same order_id
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                               // Check if the order_id is already in the summarizedOrders array
                if (isset($summarizedOrders[$order->id])) {
                                   // If it exists, add the current item's price to the existing total
                    $summarizedOrders[$order->id]['total_price'] += $item->price * $item->quantity;
                } else {
                                   // If not, initialize the entry for this order_id

                    $summarizedOrders[$order->id] = [
                        'accountid' => $accountid,
                        'order_id' => $item->order_id,
                        'total_price' => $item->price * $item->quantity,
                        'status' => $order->status,
                    ];
                }
            }
        }  
            return view('invoice.rekap-order', compact('summarizedOrders'));
    }

    public function detailorder($id){
        $orderItems = OrderItem::where("order_id", $id)->get();
        // return $orderItems;
        return view("invoice.detail-order", compact("orderItems", "id"));
    }
    
}
