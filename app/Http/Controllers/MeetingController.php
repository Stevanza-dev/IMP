<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Member;

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
            'date' => 'required|date',
            'latitude' => 'required|numeric', // Wajib ada
            'longitude' => 'required|numeric', // Wajib ada
        ]);

        // Buat Rapat Baru
        $meeting = Meeting::create([
            'title' => $request->title,
            'date' => $request->date,
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

        $attendances = $meeting->attendances()->with('member')->get();

        // 1. Ambil List Member yang HADIR (Status = present)
        $presentMembers = $attendances->where('status', 'present')->sortBy('check_in_at');

        // 2. Ambil List Member yang IZIN (Status = permission)
        $permissionMembers = $attendances->where('status', 'permission')->sortBy('check_in_at');

        // 3. Ambil List Member yang TIDAK ADA DATA ABSENSI (Alpha)
        $attendedMemberIds = $attendances->pluck('member_id')->toArray();

        $absentMembers = Member::whereNotIn('id', $attendedMemberIds)
            ->orderBy('division', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Statistik
        $totalMembers = Member::count();
        $totalPresent = $presentMembers->count();
        $totalPermission = $permissionMembers->count();
        $totalAbsent = $absentMembers->count();

        // Persentase Kehadiran (Hadir / Total)
        // Izin tidak dihitung sebagai hadir, tapi mengurangi jumlah alpha.
        $attendanceRate = $totalMembers > 0 ? round(($totalPresent / $totalMembers) * 100) : 0;

        return view('admin.meetings.recap', compact(
            'meeting',
            'presentMembers',
            'permissionMembers',
            'absentMembers',
            'totalMembers',
            'totalPresent',
            'totalPermission',
            'totalAbsent',
            'attendanceRate'
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