<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilliardController;
use App\Http\Controllers\ProdukController;
Route::get('/', function () {
    return view('index');
});

Route::resource('bl', BilliardController::class);
Route::get('bl/menu/{id}', [BilliardController::class, 'menu'])->name('bl.menu');
Route::get('bl/nonmember/{id}', [BilliardController::class, 'nonmember'])->name('bl.nonmember');
Route::get('bl/member/{id}', [BilliardController::class, 'member'])->name('bl.member');
Route::post('bl/member/post', [BilliardController::class, 'storemember'])->name('bl.storemember');
Route::post('bl/member/post2', [BilliardController::class, 'storemember2'])->name('bl.storemember2');
// Route::get('bl/stop/{id}', [BilliardController::class, 'stop'])->name('bl.stop');
Route::get('/stop/{nomor_meja}', [BilliardController::class, 'stop'])->name('bl.stop');

Route::post('bl/bayar/', [BilliardController::class, 'bayar'])->name('bl.bayar');

Route::resource('produk', ProdukController::class);
Route::get('pr/stok', [ProdukController::class, 'stok'])->name('pr.stok');
Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
