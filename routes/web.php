<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//
// AUTH
//
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']); // Daftar Anggota
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//
// ADMIN
//
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // CRUD Buku
        Route::resource('books', BookController::class);

        // CRUD User (Anggota)
        Route::resource('users', UserController::class);

        // CRUD Transaksi
        Route::resource('transactions', TransactionController::class);
    });


//
// SISWA
//
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->group(function () {

        Route::get('/dashboard', [SiswaController::class, 'index'])
            ->name('siswa.dashboard');

        // Peminjaman Buku
        Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku']);

        // Pengembalian Buku
        Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku']);
    });