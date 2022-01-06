<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EquipmentController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\DetailOrderController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TenantController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
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
Route::post('orders', [OrderController::class, 'store'])->name('store');
Route::post('detail-orders', [DetailOrderController::class, 'store'])->name('store');
Route::post('equipments', [EquipmentController::class, 'store'])->name('store');
// Route::resource('tenants', TenantController::class);


Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function() {
    // manggil controller sesuai bawaan laravel 8
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // manggil controller dengan mengubah namespace di RouteServiceProvider.php biar bisa kayak versi2 sebelumnya
    Route::post('logoutall', 'AuthController@logoutall')->name('logoutall');
});


// //API route for register new user
// Route::post('/register', [AuthController::class, 'register'])->name('register');
// //API route for login user
// Route::post('/login', [AuthController::class, 'login'])->name('login');

// //Protecting Routes
// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::get('/profile', function(Request $request) {
//         return auth()->user();
//     });

//     // API route for logout user
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });