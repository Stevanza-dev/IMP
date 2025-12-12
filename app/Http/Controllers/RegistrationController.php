<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    /**
     * Menampilkan Form Pendaftaran (Halaman Public)
     */
    public function create()
    {
        return view('registrations.create');
    }

    /**
     * Memproses Data Pendaftaran & Upload Gambar
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        // Kita pastikan email valid dan gambar bukti bayar sesuai aturan
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:dns|max:255', // email:dns mengecek apakah domain email valid
            'address' => 'required|string|max:1000',
            'phone' => 'required|string|max:20',
            'institution' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Handle Upload Gambar
        // Gambar akan disimpan di folder: cloudinary/uploads
        if ($request->hasFile('payment_proof')) {
            // Gunakan disk cloudinary
            $filePath = $request->file('payment_proof')->store('uploads', 'cloudinary');

            // URL gambar yang bisa diakses publik
            $url = $filePath; // Cloudinary biasanya langsung mengembalikan URL atau ID
            // Jika butuh URL lengkap:
            $url = cloudinary()->getUrl($filePath);
            $validated['payment_proof'] = $filePath;
        }

        // 3. Simpan ke Database
        // Status otomatis 'pending' sesuai default di database
        Registration::create($validated);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('registration.create')
            ->with('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi admin 1x24 jam. Cek email Anda secara berkala.');
    }
}