<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('barang.index');
});

Route::resource('barang', BarangController::class);
Route::resource('barang-masuk', BarangMasukController::class);
Route::resource('barang-keluar', BarangKeluarController::class);
