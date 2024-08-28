<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilliardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HargaController;
use App\Models\RentalInvoice;
use App\Models\Rental;
use App\Models\Order;
use App\Models\Member;
use App\Models\NonMember;
use Carbon\Carbon;

Route::get('/', function () {
    date_default_timezone_set('Asia/Jakarta');
    $todayDate = Carbon::today()->toDateString();
    $today_order = RentalInvoice::whereDate('waktu_mulai',$todayDate)->count();
    $member = Member::all()->count();
    $nonmember = NonMember::all()->count();

    return view('index',compact('today_order','member','nonmember'));
    // $orders = Rental::where('no_meja','1')->first();
        // Buat order
        // return Order::where('id_table',$orders->id)->get();
});

Route::get('/test', function () {
    return view('billiard.test');
});

Route::get('/print-receipt/{no_meja}', [BilliardController::class, 'print'])->name('print.receipt');

Route::resource('bl', BilliardController::class);
// Route::get('bl/rekap', [BilliardController::class, 'rekap'])->name('bl.rekap');
// Route::get('bl/rekap2', [BilliardController::class, 'rekap2'])->name('bl.rekap2');
Route::get('invoice/rekap', [BilliardController::class, 'rekapinvoice'])->name('bl.rekap');
Route::get('invoice/showrekap/{id}', [BilliardController::class, 'showrekap'])->name('bl.showrekap');

Route::get('bl/menu/{id}', [BilliardController::class, 'menu'])->name('bl.menu');
Route::get('bl/nonmember/{id}', [BilliardController::class, 'nonmember'])->name('bl.nonmember');
Route::get('/print', [BilliardController::class, 'print']);

//meber
Route::get('bl/menumember/{id}', [BilliardController::class, 'menumember'])->name('bl.menumember');
Route::get('bl/memberlanjutan/{id}', [BilliardController::class, 'memberlanjutan'])->name('bl.memberlanjutan');
Route::get('bl/memberperwaktu/{id}', [BilliardController::class, 'memberperwaktu'])->name('bl.memberperwaktu');
Route::post('bl/member/post', [BilliardController::class, 'storemember'])->name('bl.storemember');
Route::post('bl/member/post2', [BilliardController::class, 'storemember2'])->name('bl.storemember2');

//non-member
Route::get('bl/menunonmember/{id}', [BilliardController::class, 'menunonmember'])->name('bl.menunonmember');
Route::get('bl/nonmemberlanjutan/{id}', [BilliardController::class, 'nonmemberlanjutan'])->name('bl.nonmemberlanjutan');
Route::get('bl/nonmemberperwaktu/{id}', [BilliardController::class, 'nonmemberperwaktu'])->name('bl.nonmemberperwaktu');
Route::post('bl/nonmember/post', [BilliardController::class, 'storenonmember'])->name('bl.storenonmember');
Route::post('bl/nonmember/post2', [BilliardController::class, 'storenonmember2'])->name('bl.storenonmember2');

Route::get('/stop/{nomor_meja}', [BilliardController::class, 'stop'])->name('bl.stop');

Route::post('bl/bayar/', [BilliardController::class, 'bayar'])->name('bl.bayar');

Route::resource('produk', ProdukController::class);
Route::get('pr/stok', [ProdukController::class, 'stok'])->name('pr.stok');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders2', [OrderController::class, 'store2'])->name('orders.store2');

//member
Route::resource('member', MemberController::class);

//harga
Route::resource('harga', HargaController::class);
