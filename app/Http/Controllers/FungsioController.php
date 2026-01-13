<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Fungsio;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FungsioController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Ambil data fungsio berdasarkan user_id; jika belum ada, buat instance kosong
        $fungsio = Fungsio::firstOrNew(['user_id' => $user->id]);

        $divisions = Division::orderBy('name')->get();
        $periods = Period::orderBy('tahun', 'desc')->get();

        return view('fungsio.profile', compact('user', 'fungsio', 'divisions', 'periods'));
    }

    public function index()
    {
        // Ambil semua divisi beserta fungsionarisnya
        $divisions = Division::with(['fungsios' => function ($q) {
            $q->with(['user', 'period'])->orderBy('jabatan');
        }])->orderBy('name')->get();

        return view('fungsio.list', compact('divisions'));
    }

    public function stat(){
        $totalFungsio = Fungsio::count();

        $angkatan2023 = Fungsio::where('year', '2023')->count();
        $angkatan2024 = Fungsio::where('year', '2024')->count();

        $totalAktif = Fungsio::where('status', 'aktif')->count();
        $totalAlumni = Fungsio::where('status', 'alumni')->count();

        $perAngkatan = Fungsio::select('year', DB::raw('COUNT(*) as total'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $perDivisi = Division::withCount('fungsios')
            ->orderBy('name')
            ->get();

        return view('fungsio.stat', compact(
            'totalFungsio',
            'angkatan2023',
            'angkatan2024',
            'totalAktif',
            'totalAlumni',
            'perAngkatan',
            'perDivisi'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'division_id' => ['required', 'exists:divisions,id'],
            'period_id' => ['required', 'exists:periods,id'],
            'nickname' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:30'],
            'jabatan' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:4'],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'status' => ['required', 'in:alumni,aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data['user_id'] = $user->id;

        // Handle upload foto profil (opsional) ke Cloudinary
        if ($request->hasFile('foto')) {
            $uploadedFile = $request->file('foto');
            $path = $uploadedFile->getPathname();

            $uploadResult = Cloudinary::uploadApi()->upload($path, [
                'folder' => 'FungsioProfile',
                'resource_type' => 'image',
            ]);

            // Simpan public_id dan url ke kolom string
            $data['foto_public'] = $uploadResult['public_id'] ?? null;
            $data['foto_url'] = $uploadResult['secure_url'] ?? null;
        }

        Fungsio::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('fungsio.profile.edit')->with('status', 'Profil fungsio berhasil disimpan.');
    }
}
