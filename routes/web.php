<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilliardController;
use App\Http\Controllers\ProdukController;
Route::get('/', function () {
    return view('welcome');
});

Route::resource('bl', BilliardController::class);
Route::get('bl/menu/{id}', [BilliardController::class, 'menu'])->name('bl.menu');
Route::get('bl/nonmember/{id}', [BilliardController::class, 'nonmember'])->name('bl.nonmember');
Route::get('bl/member/{id}', [BilliardController::class, 'member'])->name('bl.member');
Route::post('bl/member/post', [BilliardController::class, 'storemember'])->name('bl.storemember');
Route::get('bl/stop/{id}', [BilliardController::class, 'stop'])->name('bl.stop');
Route::post('bl/bayar/', [BilliardController::class, 'bayar'])->name('bl.bayar');

Route::resource('produk', ProdukController::class);
Route::get('pr/stok', [ProdukController::class, 'stok'])->name('pr.stok');
