<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Route untuk Kriteria
    Route::resource('kriteria', KriteriaController::class);
    
    // Route untuk Siswa
    Route::resource('siswa', SiswaController::class);

    // Route untuk Penilaian Siswa
    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [App\Http\Controllers\PenilaianSiswaController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\PenilaianSiswaController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\PenilaianSiswaController::class, 'store'])->name('store');
        Route::get('/show/{siswa}', [App\Http\Controllers\PenilaianSiswaController::class, 'show'])->name('show');
        Route::delete('/destroy', [App\Http\Controllers\PenilaianSiswaController::class, 'destroy'])->name('destroy');
    });

    // Route untuk Fuzzy-AHP
    Route::prefix('fuzzy-ahp')->name('fuzzy-ahp.')->group(function () {
        Route::get('/', [App\Http\Controllers\FuzzyAhpController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\FuzzyAhpController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\FuzzyAhpController::class, 'store'])->name('store');
        Route::get('/calculate', [App\Http\Controllers\FuzzyAhpController::class, 'calculate'])->name('calculate');
        Route::post('/reset', [App\Http\Controllers\FuzzyAhpController::class, 'reset'])->name('reset');
    });

    // Route untuk MOORA
    Route::prefix('moora')->name('moora.')->group(function () {
        Route::get('/', [App\Http\Controllers\MooraController::class, 'index'])->name('index');
        Route::get('/calculate', [App\Http\Controllers\MooraController::class, 'calculate'])->name('calculate');
        Route::get('/ranking', [App\Http\Controllers\MooraController::class, 'ranking'])->name('ranking');
        Route::post('/reset', [App\Http\Controllers\MooraController::class, 'reset'])->name('reset');
    });

    // Route untuk Export
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/', [App\Http\Controllers\ExportController::class, 'index'])->name('index');
        Route::get('/ranking-pdf', [App\Http\Controllers\ExportController::class, 'rankingPdf'])->name('ranking.pdf');
        Route::get('/ranking-excel', [App\Http\Controllers\ExportController::class, 'rankingExcel'])->name('ranking.excel');
        Route::get('/detail-pdf', [App\Http\Controllers\ExportController::class, 'detailPdf'])->name('detail.pdf');
        Route::get('/detail-excel', [App\Http\Controllers\ExportController::class, 'detailExcel'])->name('detail.excel');
        Route::get('/laporan-lengkap-pdf', [App\Http\Controllers\ExportController::class, 'laporanLengkapPdf'])->name('laporan.pdf');
    });
});