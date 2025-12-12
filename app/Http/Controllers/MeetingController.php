<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    // 1. Form Buat Rapat
    public function create()
    {
        return view('admin.meetings.create');
    }

    // 2. Simpan Rapat & Lokasi
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'latitude' => 'required|numeric', // Wajib ada
            'longitude' => 'required|numeric', // Wajib ada
        ]);

        // Buat Rapat Baru
        $meeting = Meeting::create([
            'title' => $request->title,
            'date' => now(), // Default hari ini
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'token' => Str::random(32), // Token unik 32 karakter
            'is_active' => true,
        ]);

        // Redirect ke halaman QR Code
        return redirect()->route('meetings.show', $meeting->id);
    }

    // 3. Tampilkan QR Code untuk Admin
    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        // URL yang akan dibuka peserta saat scan QR
        // Contoh: http://imp-pati.org/absen/a8s7d87as8d7a8sd
        $attendanceUrl = route('attendance.form', $meeting->token);

        return view('admin.meetings.show', compact('meeting', 'attendanceUrl'));
    }

    /**
     * Halaman Rekap Absensi Per Rapat
     */
    public function recap($id)
    {
        $meeting = Meeting::with('attendances.member')->findOrFail($id);

        // 1. Ambil semua ID member yang hadir di rapat ini
        $presentMemberIds = $meeting->attendances->pluck('member_id')->toArray();

        // 2. Ambil List Member yang TIDAK HADIR
        // (Member yang ID-nya TIDAK ADA di daftar hadir)
        $absentMembers = \App\Models\Member::whereNotIn('id', $presentMemberIds)
                            ->orderBy('division', 'asc')
                            ->orderBy('name', 'asc')
                            ->get();

        // 3. Ambil List Member yang HADIR (Join dengan tabel attendance untuk ambil jam masuk)
        // Kita sorting berdasarkan waktu check_in
        $presentMembers = $meeting->attendances()
                            ->join('members', 'meeting_attendances.member_id', '=', 'members.id')
                            ->select('meeting_attendances.*', 'members.name', 'members.division')
                            ->orderBy('meeting_attendances.check_in_at', 'asc')
                            ->get();

        // Statistik
        $totalMembers = \App\Models\Member::count();
        $totalPresent = $presentMembers->count();
        $totalAbsent  = $totalMembers - $totalPresent;
        
        // Persentase Kehadiran
        $attendanceRate = $totalMembers > 0 ? round(($totalPresent / $totalMembers) * 100) : 0;

        return view('admin.meetings.recap', compact(
            'meeting', 'presentMembers', 'absentMembers', 
            'totalMembers', 'totalPresent', 'totalAbsent', 'attendanceRate'
        ));
    }

    /**
     * Halaman Utama Manajemen Rapat (List Semua Rapat)
     */
    public function index()
    {
        // Ambil data rapat, urutkan dari yang terbaru
        $meetings = Meeting::latest()->paginate(10);
        
        return view('admin.meetings.index', compact('meetings'));
    }

    /**
     * Hapus Rapat
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        // Hapus data rapat (Otomatis data absensi ikut terhapus karena 'cascade' di migration)
        $meeting->delete();

        return redirect()->route('meetings.index')->with('success', 'Data rapat berhasil dihapus.');
    }
}