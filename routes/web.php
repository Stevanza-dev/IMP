<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\WorkProgramController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/activity', [HomeController::class, 'activity'])->name('activity');
Route::get('/sisemar', [HomeController::class, 'sisemar'])->name('sisemar');
Route::get('/ampera', [HomeController::class, 'ampera'])->name('ampera');

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
    //Fitur delete
    Route::delete('/registration/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Halaman Scan
    Route::get('/admin/scan', [AdminController::class, 'scan'])->name('admin.scan');
    // API Proses Scan
    Route::post('/admin/scan/verify', [AdminController::class, 'verify'])->name('admin.scan.verify');

    // Halaman Rekap Absensi
    Route::get('/admin/absensi', [AdminController::class, 'attendance'])->name('admin.attendance');

    // Manajemen Rapat (Admin)
    Route::get('/rapat/buat', [MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/rapat/simpan', [MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/rapat/{id}/qr', [MeetingController::class, 'show'])->name('meetings.show');

    // Rekap Absensi Rapat
    Route::get('/rapat/{id}/rekap', [MeetingController::class, 'recap'])->name('meetings.recap');

    // List Rapat (Halaman Utama Manajemen)
    Route::get('/rapat', [MeetingController::class, 'index'])->name('meetings.index');

    // Hapus Rapat
    Route::delete('/rapat/{id}', [MeetingController::class, 'destroy'])->name('meetings.destroy');

    //set database
    Route::resource('admin/socials', SocialMediaController::class);
    Route::resource('admin/divisions', DivisionController::class);
    Route::resource('admin/programs', WorkProgramController::class);
    Route::resource('admin/members', MemberController::class);
});

// Route Cek Tiket Publik
Route::get('/cek-tiket', [TicketController::class, 'index'])->name('ticket.check');

// Route untuk menampilkan form
Route::get('/daftar-ampera', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/daftar-ampera', [RegistrationController::class, 'store'])->name('registration.store'); //kirim data
Route::get('/daftar-ampera/sukses', [RegistrationController::class, 'success'])->name('registration.success'); // Halaman Sukses


// Route Absensi Peserta (Via QR Code)
Route::get('/absen-rapat/{token}', [AttendanceController::class, 'show'])->name('attendance.form');
Route::post('/absen-rapat/{token}', [AttendanceController::class, 'store'])->name('attendance.store');

require __DIR__ . '/auth.php';
