<?php

namespace App\Http\Controllers;

use App\Models\Sisemar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SisemarETicketMail;

class SisemarAdminController extends Controller
{
    // Dashboard: List semua pendaftar
    public function index()
    {
        $sisemars = Sisemar::latest()->paginate(20);
        return view('admin.sisemar.index', compact('sisemars'));
    }

    // Approve pendaftar & kirim e-ticket
    public function approve($id)
    {
        $sisemar = Sisemar::findOrFail($id);

        if ($sisemar->status !== 'pending') {
            return back()->with('error', 'Peserta sudah diproses sebelumnya.');
        }

        // Generate E-Ticket Code (Barcode Digital)
        $eTicketCode = 'SISEMAR2026-' . strtoupper(Str::random(8));

        $sisemar->update([
            'status' => 'confirmed',
            'e_ticket_code' => $eTicketCode,
        ]);

        // Kirim Email E-Ticket
        Mail::to($sisemar->email)->send(new SisemarETicketMail($sisemar));

        return back()->with('success', 'Pendaftaran disetujui! E-Ticket telah dikirim ke ' . $sisemar->email);
    }

    // Reject pendaftar
    public function reject(Request $request, $id)
    {
        $sisemar = Sisemar::findOrFail($id);

        $sisemar->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('notes', 'Bukti pembayaran tidak valid'),
        ]);

        return back()->with('success', 'Pendaftaran ditolak.');
    }
}