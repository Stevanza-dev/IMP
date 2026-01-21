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
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\SisemarAdminController;
use App\Http\Controllers\SisemarAttendanceController;
use App\Http\Controllers\FungsioController;
use App\Http\Controllers\ComiteController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/activity', [HomeController::class, 'activity'])->name('activity');
Route::get('/sosmed', [HomeController::class, 'sosmed'])->name('sosmed');
Route::get('/sisemar', [HomeController::class, 'sisemar'])->name('sisemar');
Route::get('/ampera', [HomeController::class, 'ampera'])->name('ampera');

// Route Cek Tiket Publik
Route::get('/ampera/cek-tiket', [TicketController::class, 'index'])->name('ampera.ticket.check');
Route::get('/sisemar/cek-tiket', [TicketController::class, 'sisemar'])->name('sisemar.ticket.check');

// Route untuk menampilkan form pendaftaran Ampera
Route::get('/daftar-ampera', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/daftar-ampera', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/daftar-ampera/sukses', [RegistrationController::class, 'success'])->name('registration.success');
Route::get('/ampera/twibbon', [RegistrationController::class, 'twibbon'])->name('registration.twibbon');

// Route Absensi Peserta Rapat (Via QR Code Public Access for input)
Route::get('/absen-rapat/{token}', [AttendanceController::class, 'show'])->name('attendance.form');
Route::post('/absen-rapat/{token}', [AttendanceController::class, 'store'])->name('attendance.store');

// AUTH ROUTES
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Main Dashboard (General Entry Point)
    Route::get('/dashboard', function () {
        return view('dashboardall');
    })->middleware(['permission:view dashboard'])->name('dashboard');

    // -----------------------------------------------------------
    // 1. GROUP IMP (Members, Divisions, Meetings, Socials, Proker)
    // -----------------------------------------------------------
    Route::middleware(['permission:manage imp'])->group(function () {
        Route::get('/admin/imp/stat', [FungsioController::class, 'stat'])->name('admin.imp.stat');
        Route::get('/admin/imp/list', [FungsioController::class, 'index'])->name('admin.imp.list');
        // Resources
        Route::resource('/admin/divisions', DivisionController::class);
        Route::resource('/admin/socials', SocialMediaController::class);
        Route::resource('/admin/programs', WorkProgramController::class);
    });

    // -----------------------------------------------------------
    // 2. GROUP AMPERA (Registration Admin)
    // -----------------------------------------------------------
    Route::middleware(['permission:manage ampera'])->group(function () {
        // Dashboard Khusus Ampera (Diganti URL agar tidak bentrok)
        Route::get('/admin/ampera', [AdminController::class, 'index'])->name('admin.ampera.dashboard');

        // Toggle Open/Close Pendaftaran
        Route::post('/admin/ampera/toggle-registration', [AdminController::class, 'toggleRegistration'])->name('admin.ampera.toggle');

        // Action Buttons (Approve/Reject)
        Route::patch('/registration/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
        Route::patch('/registration/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');

        // Fitur Edit, Update, Resend & Delete
        Route::post('/registration/{id}/resend', [AdminController::class, 'resendEmail'])->name('admin.resend');
        Route::get('/registration/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/registration/{id}/update', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/registration/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

        // Halaman Scan & Verify
        Route::get('/admin/scan', [AdminController::class, 'scan'])->name('admin.scan');
        Route::post('/admin/scan/verify', [AdminController::class, 'verify'])->name('admin.scan.verify');

        // Halaman Rekap Absensi Hari H
        Route::get('/admin/absensi', [AdminController::class, 'attendance'])->name('admin.attendance');

        // Data panitia ampera 2026
        Route::resource('/admin/members', MemberController::class);

        //Halaman untuk rapat panitia atau rapat besar (manajemen rapat)
        Route::get('/rapat', [MeetingController::class, 'index'])->name('meetings.index');
        Route::get('/rapat/buat', [MeetingController::class, 'create'])->name('meetings.create');
        Route::post('/rapat/simpan', [MeetingController::class, 'store'])->name('meetings.store');
        Route::get('/rapat/{id}/qr', [MeetingController::class, 'show'])->name('meetings.show');
        Route::get('/rapat/{id}/rekap', [MeetingController::class, 'recap'])->name('meetings.recap');
        Route::delete('/rapat/{id}', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    });

    // -----------------------------------------------------------
    // 3. GROUP SI SEMAR
    // -----------------------------------------------------------
    Route::middleware(['permission:manage sisemar'])->prefix('admin/sisemar')->group(function () {
        // Dashboard (menggunakan Livewire)
        Route::get('/', [SisemarAdminController::class, 'index'])->name('admin.sisemar.index');

        // Absensi Hari H (Langsung scan E-Ticket dari email)
        Route::get('/attendance/scan', [SisemarAttendanceController::class, 'scanPage'])->name('admin.sisemar.attendance.scan');
        Route::post('/attendance/check-in', [SisemarAttendanceController::class, 'checkIn'])->name('admin.sisemar.attendance.checkin');
        Route::get('/attendance/recap', [SisemarAttendanceController::class, 'recap'])->name('admin.sisemar.attendance.recap');
    });

    // -----------------------------------------------------------
    // 4. GROUP SUPER ADMIN (Manajemen User/Role)
    // -----------------------------------------------------------
    Route::middleware(['role:super-admin'])->group(function () {
        Route::resource('/admin/role', RoleController::class);
        Route::resource('/admin/users', UserController::class);
        Route::resource('/admin/periods', PeriodController::class);
    });

    // 5. Fungsionaris
    Route::middleware(['role:fungsio'])->prefix('fungsio')->name('fungsio.')->group(function () {
        // Halaman profil fungsio (melihat & melengkapi data diri)
        Route::get('/profil', [FungsioController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [FungsioController::class, 'update'])->name('profile.update');

        Route::get('/list', [FungsioController::class, 'index'])->name('list');

        // Buat & kelola kepanitiaan (resource utama)
        Route::resource('/comite', ComiteController::class)->names([
            'index' => 'comite.index',
            'create' => 'comite.create',
            'store' => 'comite.store',
            'show' => 'comite.show',
            'edit' => 'comite.edit',
            'update' => 'comite.update',
            'destroy' => 'comite.destroy',
        ]);
        // Kepanitiaan yang diikuti fungsio (detail terpisah, URL berbeda agar tidak menimpa route show di atas)
        Route::get('/mycomite/{comite}', [ComiteController::class, 'myComiteShow'])->name('comite.my.show');
        // Verifikasi kepanitiaan oleh ketua panitia
        Route::post('/comite/{comite}/verify', [ComiteController::class, 'verify'])->name('comite.verify');
        // Manajemen anggota kepanitiaan oleh fungsio pembuat
        Route::post('/comite/{comite}/members', [ComiteController::class, 'storeMember'])->name('comite.members.store');
        Route::delete('/comite/{comite}/members/{member}', [ComiteController::class, 'destroyMember'])->name('comite.members.destroy');
    });

});

require __DIR__ . '/auth.php';
