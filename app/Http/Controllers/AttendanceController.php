<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Member;
use App\Models\MeetingAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * 1. Tampilkan Form Absensi (Saat QR discan)
     */
    public function show($token)
    {
        // Cari rapat berdasarkan token
        $meeting = Meeting::where('token', $token)->where('is_active', true)->firstOrFail();

        // Ambil data semua panitia untuk dropdown
        $members = Member::orderBy('name', 'asc')->get();

        return view('attendance.form', compact('meeting', 'members'));
    }

    /**
     * 2. Proses Simpan Absensi + Validasi Jarak
     */
    public function store(Request $request, $token)
    {
        $meeting = Meeting::where('token', $token)->firstOrFail();

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:present,permission',
            'latitude' => 'required_if:status,present|nullable|numeric',
            'longitude' => 'required_if:status,present|nullable|numeric',
            'notes' => 'required_if:status,permission|nullable|string',
        ]);

        // Cek apakah sudah pernah absen?
        $existing = MeetingAttendance::where('meeting_id', $meeting->id)
            ->where('member_id', $request->member_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absensi sebelumnya.');
        }

        $distance = null;

        // Cek Lokasi HANYA JIKA Status = Hadir
        if ($request->status === 'present') {
            // --- HITUNG JARAK (Haversine Formula) ---
            $distance = $this->calculateDistance(
                $meeting->latitude,
                $meeting->longitude, // Titik Pusat Rapat
                $request->latitude,
                $request->longitude  // Posisi Peserta
            );

            // Batas toleransi jarak (meter)
            $radiusLimit = 20;

            if ($distance > $radiusLimit) {
                return back()->with('error', "GAGAL! Anda berada di luar area rapat. Jarak Anda: " . round($distance) . " meter. Harap mendekat ke lokasi.");
            }
        }

        // Jika Lolos Validasi (atau Izin)
        MeetingAttendance::create([
            'meeting_id' => $meeting->id,
            'member_id' => $request->member_id,
            'check_in_at' => now(),
            'distance_in_meters' => $distance, // Bisa null jika izin
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $msg = $request->status === 'present'
            ? 'Absensi Berhasil! Jarak: ' . round($distance) . 'm. Selamat Rapat.'
            : 'Izin Berhasil Tercatat.';

        return back()->with('success', $msg);
    }

    /**
     * Rumus Matematika Menghitung Jarak 2 Koordinat (Return Meter)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}