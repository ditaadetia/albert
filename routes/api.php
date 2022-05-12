<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EquipmentController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\RefundController;
use App\Http\Controllers\API\RescheduleController;
use App\Http\Controllers\API\DetailOrderController;
use App\Http\Controllers\API\DetailRefundController;
use App\Http\Controllers\API\formulirSewaController;
use App\Http\Controllers\API\paymentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TenantController;
use GuzzleHttp\Middleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/tenant', function (Request $request) {
    return $request->user();
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/salah_password', function () {
    return view('salah_password');
})->middleware('guest');

Route::get('/header', function () {
    return view('layouts.header_default');
})->name('header')->middleware('auth');

/** Dita's original routes */
// Route::get('/alat_berat', [EquipmentController::class, 'index']);

// Route::post('/tambah_alat/post', [EquipmentController::class, 'store']);

// Route::get('/tambah_alat', [EquipmentController::class, 'create']);

// Route::get('/edit_alat', [EquipmentController::class, 'edit']);

// Route::post('/edit_alat/edit', [EquipmentController::class, 'update']);

/** Dave's improved routes */

// Route::name('equipments.')->group(function () {
//     Route::get('equipments', [EquipmentController::class, 'index'])->name('index');
//     Route::get('equipments/create', [EquipmentController::class, 'create'])->name('create');
//     Route::post('equipments', [EquipmentController::class, 'store'])->name('store');
//     Route::get('equipments/{equipment}', [EquipmentController::class, 'show'])->name('show');
//     Route::get('equipments/{equipment}/edit', [EquipmentController::class, 'edit'])->name('edit');
//     Route::put('equipments/{equipment}', [EquipmentController::class, 'update'])->name('update');
//     Route::delete('equipments/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy');
// });

Route::resource('equipments', EquipmentController::class);
Route::get('equipments-all', [EquipmentController::class, 'all'])->name('all');
Route::get('equipments-detail/{id}', [EquipmentController::class, 'detail'])->name('detail');
Route::post('orders/post/{id}', [OrderController::class, 'store'])->name('store');
Route::post('orders/post/ktp/{id}', [OrderController::class, 'ktp'])->name('ktp');
Route::post('orders/post/aktaNotaris/{id}', [OrderController::class, 'aktaNotaris'])->name('aktaNotaris');
Route::post('orders/post/suratPengantar/{id}', [OrderController::class, 'suratPengantar'])->name('suratPengantar');
Route::get('orders/{id}', [OrderController::class, 'index'])->name('index');
Route::get('cekOrder/{id}', [OrderController::class, 'cekOrder'])->name('index');
Route::get('skrPdf/{id}', [paymentController::class, 'skrPdf'])->name('skrPdf');
Route::get('cekSkr/{id}', [paymentController::class, 'cekSkr'])->name('cekSkr');
Route::get('skr/{id}', [paymentController::class, 'skr'])->name('skr');
Route::get('cekPayments/{id}', [PaymentController::class, 'cekPayments'])->name('cekPayments');
Route::post('payments', [PaymentController::class, 'payments'])->name('payments');
Route::post('bukti-pembayaran/{id}', [paymentController::class, 'buktiPembayaran'])->name('buktiPembayaran');
Route::get('lihat-formulir-order/{id}', [OrderController::class, 'lihatFormulirOrder'])->name('lihatFormulirOrder');
Route::post('orders/post/ttdPemohon/{id}', [OrderController::class, 'ttdPemohon'])->name('ttdPemohon');
Route::get('schedule/{id}', [OrderController::class, 'schedule'])->name('schedule');
Route::get('refunds', [RefundController::class, 'index'])->name('index');
Route::post('pembatalan/{id}', [RefundController::class, 'pembatalan'])->name('pembatalan');
Route::get('riwayat-pembatalan/{id}', [RefundController::class, 'riwayatPembatalan'])->name('riwayatPembatalan');
Route::get('formulir-sewa/{id}', [formulirSewaController::class, 'formulirSewa'])->name('formulirSewa');
Route::get('downloadDokumenSewa/{id}', [OrderController::class, 'downloadDokumenSewa'])->name('downloadDokumenSewa');
Route::post('detail-orders/post/{id}', [DetailOrderController::class, 'store'])->name('store');
Route::get('detail-orders', [DetailOrderController::class, 'index'])->name('index');
Route::post('refunds/{id}', [RefundController::class, 'store'])->name('store');
Route::post('detail-refunds/{id}', [DetailRefundController::class, 'store'])->name('store');
Route::get('reschedules/{id}', [RescheduleController::class, 'index'])->name('index');
Route::post('reschedules/post', [RescheduleController::class, 'store'])->name('store');
Route::post('equipments', [EquipmentController::class, 'store'])->name('store');
Route::get('cekUser/{id}', [AuthController::class, 'cekUser'])->name('cekUser');
// Route::resource('tenants', TenantController::class);


// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function() {
//     // manggil controller sesuai bawaan laravel 8
//     Route::post('logout', [AuthController::class, 'logout'])->name('logout');
//     // manggil controller dengan mengubah namespace di RouteServiceProvider.php biar bisa kayak versi2 sebelumnya
//     Route::post('logoutall', 'AuthController@logoutall')->name('logoutall');
// });

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('editProfil/{id}', [App\Http\Controllers\API\AuthController::class, 'editProfil'])->name('editProfil');
Route::post('updatePicture/{id}', [App\Http\Controllers\API\AuthController::class, 'updatePicture'])->name('updatePicture');
// Route::put('/editProfil', [App\Http\Controllers\API\TenantController::class, 'editProfil']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    // Route::resource('tenants', [App\Http\Controllers\API\AuthController::class]);
    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});