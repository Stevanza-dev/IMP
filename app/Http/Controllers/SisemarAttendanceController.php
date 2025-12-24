<?php

namespace App\Http\Controllers;

use App\Models\Sisemar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SisemarAttendanceController extends Controller
{
    // Halaman Scan Tiket Fisik
    public function scanPage()
    {
        return view('admin.sisemar.attendance.scan');
    }

    // Proses Scan Tiket Fisik (Hari H)
    public function checkIn(Request $request)
    {
        $request->validate([
            'physical_ticket_code' => 'required|string',
        ]);

        $sisemar = Sisemar::where('physical_ticket_code', strtoupper($request->physical_ticket_code))->first();

        if (!$sisemar) {
            return back()->with('error', 'Tiket fisik tidak ditemukan!');
        }

        if (!$sisemar->hasRedeemedTicket()) {
            return back()->with('error', 'Tiket fisik belum ditukar! Arahkan peserta ke booth penukaran.');
        }

        if ($sisemar->hasCheckedIn()) {
            return back()->with('warning', 'Peserta sudah check-in pada ' . $sisemar->checked_in_at->format('d M Y H:i'));
        }

        // Catat absensi
        $sisemar->update([
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Check-in berhasil! Selamat datang, ' . $sisemar->name);
    }

    // Rekap Kehadiran
    public function recap()
    {
        $stats = [
            'total' => Sisemar::where('status', 'confirmed')->count(),
            'redeemed' => Sisemar::whereNotNull('ticket_redeemed_at')->count(),
            'checked_in' => Sisemar::whereNotNull('checked_in_at')->count(),
        ];

        $attendees = Sisemar::whereNotNull('checked_in_at')
            ->with(['checkedInBy'])
            ->latest('checked_in_at')
            ->get();

        return view('admin.sisemar.attendance.recap', compact('stats', 'attendees'));
    }
}