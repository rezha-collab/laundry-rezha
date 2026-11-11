<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;


Route::resource('transaksi', TransaksiController::class)
    ->except(['show']);

Route::get('/transaksi/{transaksi}/detail',
    [TransaksiController::class, 'show']
)->name('transaksi.show');


Route::get('/pembayaran', [PembayaranController::class, 'index'])
    ->name('pembayaran.index');

Route::get('/pembayaran/{transaksi}/create',
    [PembayaranController::class, 'create']
)->name('pembayaran.create');

Route::post('/pembayaran/{transaksi}',
    [PembayaranController::class, 'store']
)->name('pembayaran.store');



Route::resource('transaksi', TransaksiController::class)
    ->except(['show']);





Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('pelanggan', PelangganController::class)
    ->except(['show']);

Route::resource('layanan', LayananController::class)
    ->except(['show']);

