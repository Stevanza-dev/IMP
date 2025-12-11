<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard khusus Admin Pendaftaran
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Action Buttons
    Route::patch('/registration/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::patch('/registration/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
    // Fitur Edit & Resend
    Route::post('/registration/{id}/resend', [AdminController::class, 'resendEmail'])->name('admin.resend');
    Route::get('/registration/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/registration/{id}/update', [AdminController::class, 'update'])->name('admin.update');

    // Halaman Scan
    Route::get('/admin/scan', [AdminController::class, 'scan'])->name('admin.scan');
    // API Proses Scan
    Route::post('/admin/scan/verify', [AdminController::class, 'verify'])->name('admin.scan.verify');

    // Halaman Rekap Absensi
    Route::get('/admin/absensi', [AdminController::class, 'attendance'])->name('admin.attendance');
});

// Route Cek Tiket Publik
Route::get('/cek-tiket', [TicketController::class, 'index'])->name('ticket.check');

// Route untuk menampilkan form
Route::get('/daftar-ampera', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/daftar-ampera', [RegistrationController::class, 'store'])->name('registration.store'); //kirim data

require __DIR__.'/auth.php';
