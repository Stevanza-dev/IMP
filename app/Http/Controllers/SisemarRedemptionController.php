<?php

namespace App\Http\Controllers;

use App\Models\Sisemar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SisemarRedemptionController extends Controller
{
    // Halaman Scan E-Ticket
    public function scanPage()
    {
        return view('admin.sisemar.redemption.scan');
    }

    // Redirect jika user akses /check via GET
    public function redirectCheck()
    {
        return redirect()->route('admin.sisemar.redemption.scan');
    }

    // Cek Validasi E-Ticket (Langkah 1)
    public function check(Request $request)
    {
        $request->validate(['e_ticket_code' => 'required|string']);

        $sisemar = Sisemar::where('e_ticket_code', $request->e_ticket_code)->first();

        // Error handling
        if (!$sisemar)
            return back()->with('error', 'E-Ticket tidak ditemukan!');
        if ($sisemar->status !== 'confirmed')
            return back()->with('error', 'Status peserta belum dikonfirmasi (Pending/Rejected).');
        if ($sisemar->hasRedeemedTicket())
            return back()->with('error', 'Tiket ini SUDAH ditukarkan pada: ' . $sisemar->ticket_redeemed_at);

        // Jika valid, kembalikan ke view scan dengan data peserta
        return view('admin.sisemar.redemption.scan', compact('sisemar'));
    }

    // Proses Simpan Tiket Fisik (Langkah 2)
    public function process(Request $request)
    {
        $request->validate([
            'sisemar_id' => 'required|exists:sisemars,id',
            'physical_ticket_code' => 'required|string|unique:sisemars,physical_ticket_code',
        ]);

        $sisemar = Sisemar::findOrFail($request->sisemar_id);

        $sisemar->update([
            'physical_ticket_code' => strtoupper($request->physical_ticket_code),
            'ticket_redeemed_at' => now(),
        ]);

        return redirect()->route('admin.sisemar.redemption.success', $sisemar->id);
    }

    // Halaman Sukses Penukaran
    public function success($id)
    {
        $sisemar = Sisemar::findOrFail($id);
        return view('admin.sisemar.redemption.success', compact('sisemar'));
    }

    // Halaman Status Penukaran Tiket
    public function status()
    {
        // Statistik
        $stats = [
            'total_confirmed' => Sisemar::where('status', 'confirmed')->count(),
            'redeemed' => Sisemar::whereNotNull('ticket_redeemed_at')->count(),
            'pending_redemption' => Sisemar::where('status', 'confirmed')
                ->whereNotNull('e_ticket_code')
                ->whereNull('ticket_redeemed_at')
                ->count(),
        ];

        // Hitung persentase
        if ($stats['total_confirmed'] > 0) {
            $stats['redeemed_percentage'] = round(($stats['redeemed'] / $stats['total_confirmed']) * 100, 2);
        } else {
            $stats['redeemed_percentage'] = 0;
        }

        // Data Peserta
        $participants = Sisemar::where('status', 'confirmed')
            ->orderBy('ticket_redeemed_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sisemar.redemption.status', compact('stats', 'participants'));
    }
}