<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Revolution\Google\Sheets\Facades\Sheets;

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
            'email' => 'required|email:dns|max:255|unique:registrations,email',
            'address' => 'required|string|max:1000',
            'phone' => 'required|string|max:20',
            'institution' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'email.unique' => 'Email ini sudah terdaftar sebelumnya.',
            'email.email' => 'Format email tidak valid.',
            'email.required' => 'Email harus diisi.',
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
        $registration = Registration::create($validated);

        // 4. Kirim ke Google Sheets
        try {
            $spreadsheetId = config('google.spreadsheet_id');
            if ($spreadsheetId) {
                Sheets::spreadsheet($spreadsheetId)
                    ->sheet('Sheet1')
                    ->append([
                        [
                            $registration->created_at->format('Y-m-d H:i:s'),
                            $registration->name,
                            $registration->email,
                            "'" . $registration->phone,
                            $registration->institution,
                            $registration->address,
                            $registration->payment_method,
                            $registration->payment_url, // URL Bukti Bayar
                            'pending'
                        ]
                    ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Sheets Error: ' . $e->getMessage());
        }

        // 5. Redirect dengan Pesan Sukses
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