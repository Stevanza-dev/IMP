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