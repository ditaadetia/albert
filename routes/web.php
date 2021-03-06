<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembatalanController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SkrController;
use App\Http\Controllers\KeluarMasukAlatController;
use App\Http\Controllers\DokumenSewaController;
use App\Http\Controllers\generateSkrController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/', LoginController::class, '__invoke')->name('login')->middleware('guest');

Route::post('/logout', 'App\Http\Controllers\LoginController@logout')->middleware('auth');

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

Route::resource('equipments', EquipmentController::class)->middleware('admin');
Route::get('event', [EquipmentController::class, 'event'])->name('event')->middleware('admin_kepalauptd_kepaladinas');
Route::resource('refunds', RefundController::class)->middleware('auth');
Route::resource('users', LoginController::class)->middleware('auth');
Route::resource('reschedules', RescheduleController::class)->middleware('admin_kepalauptd');
Route::get('detail_reschedules/{id}', [RescheduleController::class, 'rescheduleShow'])->name('rescheduleShow')->middleware('admin_kepalauptd');
Route::resource('payments', PaymentController::class)->middleware('auth')->middleware('bendahara');
Route::resource('skrs', SkrController::class)->middleware('auth')->middleware('bendahara');
// Route::resource('fines', FineController::class)->middleware('auth')->middleware('bendahara');
Route::resource('keluar-masuk-alat', KeluarMasukAlatController::class)->middleware('admin');
Route::get('denda-terlambat-pengembalian', [PaymentController::class, 'denda'])->name('denda')->middleware('bendahara');
Route::get('detail-denda-terlambat-pengembalian/{id}', [PaymentController::class, 'detailDenda'])->name('detailDenda')->middleware('bendahara');
// Route::resource('category', 'App\Http\Controllers\CategoryController'::class);
Route::resource('password', PasswordController::class)->middleware('auth');
Route::put('photos/{photo}', [LoginController::class, 'updateFoto'])->name('updateFoto')->middleware('auth');
Route::get('orders/{category}', [OrderController::class, 'index'])->name('index')->middleware('admin_kepalauptd_kepaladinas');
Route::get('detail_orders/{id}', [OrderController::class, 'show'])->name('show')->middleware('admin_kepalauptd_kepaladinas');
Route::get('pembatalan', [PembatalanController::class, 'pembatalan'])->name('pembatalan')->middleware('admin_kepalauptd_kepaladinas');
Route::get('detail_pembatalan/{id}', [PembatalanController::class, 'detailPembatalan'])->name('detailPembatalan')->middleware('admin_kepalauptd_kepaladinas');
Route::get('download-permohonan/{id}', [OrderController::class, 'downloadPermohonan'])->name('downloadPermohonan')->middleware('admin_kepalauptd_kepaladinas');
Route::get('download-akta/{id}', [OrderController::class, 'downloadAkta'])->name('downloadAkta')->middleware('admin_kepalauptd_kepaladinas');
Route::get('download-ktp/{id}', [OrderController::class, 'downloadKtp'])->name('downloadAkta')->middleware('admin_kepalauptd_kepaladinas');
Route::get('download-pengantar/{id}', [OrderController::class, 'downloadSuratPengantar'])->name('downloadSuratPengantar')->middleware('admin_kepalauptd_kepaladinas');
Route::get('download-permohonan-refund/{id}', [OrderController::class, 'downloadKtp'])->name('downloadKtp')->middleware('admin_kepalauptd_kepaladinas');
Route::get('download-bukti-pembayaran/{id}', [PaymentController::class, 'downloadBuktiPembayaran'])->name('downloadBuktiPembayaran')->middleware('bendahara');

Route::get('verifikasi-admin/{id}', [OrderController::class, 'verifAdmin'])->name('verifAdmin')->middleware('admin');
Route::get('verifikasi-refund-admin/{id}', [RefundController::class, 'verifRefundAdmin'])->name('verifRefundAdmin')->middleware('admin');
Route::get('verifikasi-reschedule-admin/{id}', [RescheduleController::class, 'verifRescheduleAdmin'])->name('verifRescheduleAdmin')->middleware('admin');
Route::put('tolak-admin/{id}', [OrderController::class, 'tolakAdmin'])->name('tolakAdmin')->middleware('admin');
Route::put('tolak-refund-admin/{id}', [RefundController::class, 'tolakRefundAdmin'])->name('tolakRefundAdmin')->middleware('admin');
Route::put('tolak-reschedule-admin/{id}', [RescheduleController::class, 'tolakRescheduleAdmin'])->name('tolakRescheduleAdmin')->middleware('admin');

Route::get('verifikasi-kepala-uptd/{id}', [OrderController::class, 'setujuKepalaUPTD'])->name('setujuKepalaUPTD')->middleware('kepala_uptd');
Route::get('terbit-skr/{id}', [SkrController::class, 'setujuBendahara'])->name('setujuBendahara')->middleware('bendahara');
Route::get('verifikasi-refund-kepala-uptd/{id}', [RefundController::class, 'setujuRefundKepalaUPTD'])->name('setujuRefundKepalaUPTD')->middleware('kepala_uptd');
Route::get('verifikasi-reschedule-kepala-uptd/{id}', [RescheduleController::class, 'setujuRescheduleKepalaUPTD'])->name('setujuRescheduleKepalaUPTD')->middleware('kepala_uptd');
Route::get('editSchedule/{id}', [RescheduleController::class, 'editSchedule'])->name('editSchedule')->middleware('kepala_uptd');
Route::put('tolak-kepala-uptd/{id}', [OrderController::class, 'tolakKepalaUPTD'])->name('tolakKepalaUPTD')->middleware('kepala_uptd');
Route::put('tolak-refund-kepala-uptd/{id}', [RefundController::class, 'tolakRefundKepalaUPTD'])->name('tolakRefundKepalaUPTD')->middleware('kepala_uptd');
Route::put('tolak-reschedule-kepala-uptd/{id}', [RescheduleController::class, 'tolakRescheduleKepalaUPTD'])->name('tolakRescheduleKepalaUPTD')->middleware('kepala_uptd');
Route::put('refund-bendahara/{id}', [RefundController::class, 'refundBendahara'])->name('refundBendahara')->middleware('bendahara');

Route::get('verifikasi-kepala-dinas/{id}', [OrderController::class, 'setujuKepalaDinas'])->name('setujuKepalaDinas')->middleware('kepala_dinas');
Route::get('verifikasi-refund-kepala-dinas/{id}', [RefundController::class, 'setujuRefundKepalaDinas'])->name('setujuRefundKepalaDinas')->middleware('kepala_dinas');
Route::get('hapusSchedule/{id}', [RefundController::class, 'hapusSchedule'])->name('hapusSchedule')->middleware('kepala_dinas');
Route::put('tolak-kepala-dinas/{id}', [OrderController::class, 'tolakKepalaDinas'])->name('tolakKepalaDinas')->middleware('kepala_dinas');
Route::put('tolak-refund-kepala-dinas/{id}', [RefundController::class, 'tolakRefundKepalaDinas'])->name('tolakRefundKepalaDinas')->middleware('kepala_dinas');

Route::get('verifikasi-pembayaran/{id}', [PaymentController::class, 'verifPembayaran'])->name('verifPembayaran')->middleware('bendahara');
Route::get('konfirmasi-denda/{id}', [PaymentController::class, 'bayarDenda'])->name('bayarDenda')->middleware('bendahara');
Route::put('tolak-pembayaran/{id}', [PaymentController::class, 'tolakPembayaran'])->name('tolakPembayaran')->middleware('auth');

// Route::get('terbit-skr/{id}', [SkrController::class, 'terbitSkr'])->name('terbitSkr')->middleware('bendahara');

Route::post('ttd-kepala-uptd/{id}', [OrderController::class, 'ttdKepalaUPTD'])->name('ttdKepalaUPTD')->middleware('kepala_uptd');
Route::post('ttd-kepala-dinas/{id}', [OrderController::class, 'ttdKepalaDinas'])->name('ttdKepalaDinas')->middleware('kepala_dinas');
Route::post('ttd-bendahara/{id}', [SkrController::class, 'ttdBendahara'])->name('ttdBendahara')->middleware('bendahara');
Route::get('generateSkr/{id}', [generateSkrController::class, 'generateSkr'])->name('generateSkr')->middleware('bendahara');


Route::get('/cari-order/{category}', [OrderController::class, 'search'])->name('search')->middleware('admin_kepalauptd_kepaladinas');
Route::get('/cari-pembatalan', [PembatalanController::class, 'searchPembatalan'])->name('searchPembatalan')->middleware('admin_kepalauptd_kepaladinas');
Route::get('/cari-refund', [RefundController::class, 'search'])->name('search')->middleware('admin_kepalauptd_kepaladinas');
Route::get('/cari-reschedule', [RescheduleController::class, 'search'])->name('search')->middleware('admin_kepalauptd_kepaladinas');
Route::get('/cari-payment', [PaymentController::class, 'search'])->name('search')->middleware('bendahara');
Route::get('/cari-skr', [SkrController::class, 'search'])->name('search')->middleware('bendahara');
Route::get('/cari-fine', [PaymentController::class, 'searchFine'])->name('searchFine')->middleware('bendahara');
Route::get('/cari-penyewa', [TenantController::class, 'search'])->name('search')->middleware('admin');
Route::get('/cari-keluar-masuk', [KeluarMasukAlatController::class, 'search'])->name('search')->middleware('admin');
Route::get('/search', [EquipmentController::class, 'search'])->name('search')->middleware('admin');
Route::resource('tenants', TenantController::class)->middleware('admin');

Route::get('/dokumenSewa', [DokumenSewaController::class, 'dokumenSewa'])->name('dokumenSewa')->middleware('auth');
Route::get('/generateSuratPersetujuan/{id}', [OrderController::class, 'generateSuratPersetujuan'])->name('generateSuratPersetujuan')->middleware('kepala_dinas');
Route::get('/lihatDokumenSewa/{id}', [DokumenSewaController::class, 'lihatDokumenSewa'])->name('lihatDokumenSewa')->middleware('auth');

Route::get('alat-keluar/{id}', [KeluarMasukAlatController::class, 'alatKeluar'])->name('alatKeluar')->middleware('admin');
Route::get('alat-masuk/{id}', [KeluarMasukAlatController::class, 'alatMasuk'])->name('alatMasuk')->middleware('admin');

Route::put('orders-excel', [OrderController::class, 'ordersExcel'])->name('ordersExcel')->middleware('kepalauptd_kepaladinas');
Route::put('payments-excel', [PaymentController::class, 'paymentExcel'])->name('paymentExcel')->middleware('bendahara');
Route::put('cancel-excel', [pembatalanController::class, 'cancelExcel'])->name('cancelExcel')->middleware('kepalauptd_kepaladinas');
Route::put('refunds-excel', [RefundController::class, 'refundsExcel'])->name('refundsExcel')->middleware('kepalauptd_kepaladinas');
Route::put('reschedules-excel', [RescheduleController::class, 'reschedulesExcel'])->name('reschedulesExcel')->middleware('kepalauptd_kepaladinas');