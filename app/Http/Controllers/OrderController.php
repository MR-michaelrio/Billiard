<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

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
        // Tambahkan items ke order
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json(['success' => true]);
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
        Log::info('Order created', ['order_id' => $request->id_table]);

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
            ]);
        }

        return response()->json(['success' => true]);
    }
}
