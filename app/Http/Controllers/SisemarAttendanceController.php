<?php

namespace App\Http\Controllers;

use App\Models\Sisemar;
use Illuminate\Http\Request;

class SisemarAttendanceController extends Controller
{
    // Halaman Scan E-Ticket (Barcode Digital dari Email)
    public function scanPage()
    {
        return view('admin.sisemar.attendance.scan');
    }

    // Proses Check-In via E-Ticket Code
    public function checkIn(Request $request)
    {
        $request->validate([
            'e_ticket_code' => 'required|string',
        ]);

        $sisemar = Sisemar::where('e_ticket_code', strtoupper($request->e_ticket_code))->first();

        if (!$sisemar) {
            return back()->with('error', 'E-Ticket tidak ditemukan! Pastikan peserta sudah terkonfirmasi.');
        }

        if (!$sisemar->isConfirmed()) {
            return back()->with('error', 'Pendaftaran belum disetujui. Status: ' . $sisemar->status);
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
            'checked_in' => Sisemar::whereNotNull('checked_in_at')->count(),
            'not_checked_in' => Sisemar::where('status', 'confirmed')
                ->whereNull('checked_in_at')
                ->count(),
        ];

        // Peserta yang sudah hadir
        $attendees = Sisemar::whereNotNull('checked_in_at')
            ->latest('checked_in_at')
            ->get();

        // Peserta terkonfirmasi tapi belum hadir
        $notCheckedIn = Sisemar::where('status', 'confirmed')
            ->whereNull('checked_in_at')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.sisemar.attendance.recap', compact('stats', 'attendees', 'notCheckedIn'));
    }
}