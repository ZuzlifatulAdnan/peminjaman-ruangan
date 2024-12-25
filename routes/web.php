<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\UserController;
use App\Models\Gedung;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/beranda');

Route::middleware(['auth'])->group(function () {
    Route::resource('beranda', BerandaController::class);
    Route::resource('gedung', GedungController::class);
    Route::resource('pemesanan', PemesananController::class);
    Route::resource('ruangan', RuanganController::class);
    Route::resource('ukm', UkmController::class);
    Route::resource('user', UserController::class);
    // Route::resource('profile', ProfileController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password-form');
    Route::post('profile/change-password/{user}', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});