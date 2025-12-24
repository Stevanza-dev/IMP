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

    // Proses Scan E-Ticket & Input Barcode Tiket Fisik
    public function process(Request $request)
    {
        $request->validate([
            'e_ticket_code' => 'required|string',
            'physical_ticket_code' => 'required|string|unique:sisemars,physical_ticket_code',
        ]);

        // Cari berdasarkan E-Ticket Code
        $sisemar = Sisemar::where('e_ticket_code', $request->e_ticket_code)->first();

        if (!$sisemar) {
            return back()->with('error', 'E-Ticket tidak ditemukan!');
        }

        if ($sisemar->status !== 'confirmed') {
            return back()->with('error', 'E-Ticket belum disetujui atau sudah ditolak.');
        }

        if ($sisemar->hasRedeemedTicket()) {
            return back()->with('error', 'Tiket fisik sudah ditukar pada ' . $sisemar->ticket_redeemed_at->format('d M Y H:i'));
        }

        // Update dengan barcode tiket fisik
        $sisemar->update([
            'physical_ticket_code' => strtoupper($request->physical_ticket_code),
            'ticket_redeemed_at' => now(),
            'redeemed_by_user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.sisemar.redemption.success', $sisemar->id);
    }

    // Halaman Sukses Penukaran
    public function success($id)
    {
        $sisemar = Sisemar::findOrFail($id);
        return view('admin.sisemar.redemption.success', compact('sisemar'));
    }
}