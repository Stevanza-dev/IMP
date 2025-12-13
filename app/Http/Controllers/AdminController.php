<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str untuk generate kode acak
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketApproved;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar pendaftar
     */
    public function index(Request $request)
    {
        // Ambil query dasar
        $query = Registration::query();

        // Filter berdasarkan status (confirmed / pending) jika ada
        $filter = $request->query('filter');
        if ($filter === 'confirmed') {
            $query->where('status', 'confirmed');
        } elseif ($filter === 'pending') {
            $query->where('status', 'pending');
        }

        // Pencarian berdasarkan nama (q)
        $q = $request->query('q');
        if (!empty($q)) {
            $query->where('name', 'like', '%' . $q . '%');
        }

        // Paginate dan pertahankan query string untuk link pagination
        $registrations = $query->latest()->paginate(10)->withQueryString();

        // Statistik ringkas (dihitung di backend)
        $totalCount = Registration::count();
        $confirmedCount = Registration::where('status', 'confirmed')->count();
        $pendingCount = Registration::where('status', 'pending')->count();

        return view('admin.dashboard', compact('registrations', 'totalCount', 'confirmedCount', 'pendingCount', 'filter', 'q'));
    }

    /**
     * Logic Approve (Konfirmasi Pembayaran)
     */
    public function approve($id)
    {
        $registration = Registration::findOrFail($id);

        // Update status dan generate Ticket Code
        $registration->update([
            'status' => 'confirmed',
            'ticket_code' => 'AMP-2026-' . strtoupper(Str::random(5))
        ]);

        // --- MULAI KIRIM EMAIL ---
        // Kita bungkus dalam try-catch agar jika internet mati, aplikasi tidak crash total
        try {
            Mail::to($registration->email)->send(new TicketApproved($registration));
        } catch (\Exception $e) {
            // Jika gagal kirim, kita tetap approve tapi beri notifikasi warning
            return redirect()->back()->with('warning', 'Peserta diapprove, tapi GAGAL kirim email. Cek koneksi internet.');
        }
        // --- SELESAI KIRIM EMAIL ---

        return redirect()->back()->with('success', 'Peserta dikonfirmasi & Email tiket terkirim!');
    }

    /**
     * Logic Reject (Tolak Pembayaran)
     */
    public function reject($id)
    {
        $registration = Registration::findOrFail($id);

        $registration->update([
            'status' => 'rejected',
            'ticket_code' => null // Pastikan tiket kosong jika ditolak
        ]);

        return redirect()->back()->with('error', 'Pendaftaran ditolak.');
    }

    /**
     * Tampilkan Halaman Scan QR
     */
    public function scan()
    {
        return view('admin.scan');
    }

    /**
     * Proses API Scan (Dipanggil via AJAX oleh Javascript)
     */
    public function verify(Request $request)
    {
        $code = $request->code;

        // 1. Cari Tiket berdasarkan Kode
        $ticket = Registration::where('ticket_code', $code)->first();

        // Kasus A: Tiket tidak ditemukan
        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'TIKET TIDAK DITEMUKAN!'
            ], 404);
        }

        // Kasus B: Tiket sudah pernah dipakai (Double Check-in)
        if ($ticket->checked_in_at) {
            return response()->json([
                'status' => 'warning',
                'message' => 'ALREADY USED! Peserta: ' . $ticket->name . ' sudah masuk pada jam ' . $ticket->checked_in_at->format('H:i')
            ]);
        }

        // Kasus C: Sukses (Valid & Belum masuk)
        // Update waktu kehadiran
        $ticket->update(['checked_in_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'BERHASIL! Selamat Datang, ' . $ticket->name,
            'data' => [
                'name' => $ticket->name,
                'institution' => $ticket->institution
            ]
        ]);
    }

    /**
     * Halaman Rekap Absensi Hari H
     */
    public function attendance()
    {
        // Hitung Statistik
        $totalPeserta = Registration::where('status', 'confirmed')->count();

        $sudahHadir = Registration::where('status', 'confirmed')
            ->whereNotNull('checked_in_at')
            ->count();

        $belumHadir = $totalPeserta - $sudahHadir;

        // Ambil data peserta (Urutkan yang baru hadir paling atas)
        // Kita hanya ambil yang statusnya 'confirmed' (sudah bayar)
        $attendees = Registration::where('status', 'confirmed')
            ->orderByRaw('checked_in_at IS NULL') // Yang hadir ditaruh atas
            ->orderBy('checked_in_at', 'desc')    // Yang baru scan paling atas
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.attendance', compact('totalPeserta', 'sudahHadir', 'belumHadir', 'attendees'));
    }

    /**
     * Fitur KIRIM ULANG EMAIL (Resend)
     */
    public function resendEmail($id)
    {
        $registration = Registration::findOrFail($id);

        if ($registration->status !== 'confirmed') {
            return back()->with('error', 'Hanya peserta berstatus CONFIRMED yang bisa dikirimi tiket.');
        }

        try {
            // Panggil Mailable yang sudah kita buat sebelumnya
            \Illuminate\Support\Facades\Mail::to($registration->email)
                ->send(new \App\Mail\TicketApproved($registration));

            return back()->with('success', 'Email tiket berhasil dikirim ulang ke: ' . $registration->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Cek koneksi internet.');
        }
    }

    /**
     * Fitur EDIT DATA (Tampilkan Form Edit)
     */
    public function edit($id)
    {
        $registration = Registration::findOrFail($id);
        return view('admin.edit', compact('registration'));
    }

    /**
     * Fitur UPDATE DATA (Simpan Perubahan)
     */
    public function update(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        // Validasi yang boleh diubah hanya Nama, Email, HP, Instansi, Alamat
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:dns',
            'phone' => 'required|string',
            'institution' => 'required|string',
            'address' => 'required|string',
        ]);

        $registration->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'institution' => $request->institution,
            'address' => $request->address,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data peserta berhasil diperbaiki.');
    }

    /**
     * Hapus Data Pendaftar (Permanen)
     */
    public function destroy($id)
    {
        // Cari data
        $registration = Registration::findOrFail($id);

        // 1. Hapus File Gambar dari Storage (Opsional tapi disarankan)
        // Pastikan Anda import facade Storage di paling atas file: use Illuminate\Support\Facades\Storage;
        if ($registration->payment_proof && \Illuminate\Support\Facades\Storage::disk('public')->exists($registration->payment_proof)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($registration->payment_proof);
        }

        // 2. Hapus Data dari Database
        $registration->delete();

        return redirect()->back()->with('success', 'Data pendaftar berhasil dihapus permanen.');
    }
}