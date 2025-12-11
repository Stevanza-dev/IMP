<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $ticket = null;
        
        // Jika ada pencarian (user mengetik sesuatu atau klik link dari email)
        if ($request->has('search')) {
            $keyword = $request->search;

            // Cari peserta berdasarkan Kode Tiket ATAU Email
            // Syarat mutlak: Status harus 'confirmed'
            $ticket = Registration::where('status', 'confirmed')
                ->where(function($query) use ($keyword) {
                    $query->where('ticket_code', $keyword)
                          ->orWhere('email', $keyword);
                })
                ->first();
                
            // Jika tidak ketemu, beri pesan error
            if (!$ticket) {
                return back()->with('error', 'Tiket tidak ditemukan atau belum lunas. Pastikan kode/email benar.');
            }
        }

        return view('ticket.show', compact('ticket'));
    }
}