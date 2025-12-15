<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

        // 2. Handle Upload Gambar (Cloudinary Upload API)
        if ($request->hasFile('payment_proof')) {
            $uploadedFile = $request->file('payment_proof');
            $path = $uploadedFile->getPathname(); // lebih aman daripada getRealPath()

            $uploadResult = Cloudinary::uploadApi()->upload($path, [
                'folder' => 'UploadBuktiBayar',
                'resource_type' => 'image',
            ]);

            // Simpan Public ID dan Secure URL
            $validated['payment_proof'] = $uploadResult['public_id'] ?? null;
            $validated['payment_url'] = $uploadResult['secure_url'] ?? null;
        }

        // 3. Simpan ke Database
        // Status otomatis 'pending' sesuai default di database
        Registration::create($validated);

        // 4. Redirect dengan Pesan Sukses
        // 4. Redirect ke Halaman Sukses
        return redirect()->route('registration.success');
    }

    /**
     * Menampilkan Halaman Sukses Pendaftaran
     */
    public function success()
    {
        return view('registrations.success');
    }
}