<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('customer/barcode/{encrypted}', [BarcodeController::class, 'show'])
    ->name('customer.barcode.show');

Route::get('customer/barcode/po/{encrypted}', [BarcodeController::class, 'showPo'])
    ->name('customer.barcode.po.show');

Route::get('customer/barcode/penawaran/{encrypted}', [BarcodeController::class, 'showPenawaran'])
    ->name('customer.barcode.show_penawaran');
