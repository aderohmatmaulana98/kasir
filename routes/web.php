<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});




Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboarController::class, 'dashboard'])->name('dashboard');

    Route::get('/barang', [BarangController::class, 'barang'])->name('barang');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::post('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

    Route::get('/user', [UsersController::class, 'users'])->name('users');
    Route::post('/user', [UsersController::class, 'store'])->name('users.store');
    Route::delete('/user/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::post('/user/{id}', [UsersController::class, 'update'])->name('users.update');

    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi.index');
    Route::post('/keranjang/tambah', [TransaksiController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{id}', [TransaksiController::class, 'hapusDariKeranjang'])->name('keranjang.hapus');
    Route::get('/keranjang/total', [TransaksiController::class, 'hitungTotal'])->name('keranjang.total');
    Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    
    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan');
});

// Dimohon hasil test dikirim ke email : nkuraesin@gmail.com (berbentuk pdf) sampai dengan jam 4 sore hari ini
// Terimakasih 🙏