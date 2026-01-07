<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Setting;

class RegistrationController extends Controller
{
    /**
     * Menampilkan Form Pendaftaran (Halaman Public)
     */
    public function create()
    {
        $registrationOpen = Setting::get('ampera_registration_open', '1') === '1';
        return view('registrations.create', compact('registrationOpen'));
    }

    /**
     * Memproses Data Pendaftaran & Upload Gambar
     */
    public function store(Request $request)
    {
        // Cek apakah pendaftaran masih dibuka
        $registrationOpen = Setting::get('ampera_registration_open', '1') === '1';
        if (!$registrationOpen) {
            return redirect()->route('registration.create')->with('error', 'Maaf, pendaftaran sudah ditutup.');
        }
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
                $credentials = config('google.service.file');

                // If creds is a file path, load it. If array (from env), use it directly.
                if (is_string($credentials) && file_exists($credentials)) {
                    $credentials = json_decode(file_get_contents($credentials), true);
                }

                if (is_array($credentials)) {
                    $token = $this->getAccessToken($credentials);

                    if ($token) {
                        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/Sheet1!A1:append?valueInputOption=USER_ENTERED";

                        \Illuminate\Support\Facades\Http::withToken($token)->post($url, [
                            'values' => [
                                [
                                    $registration->created_at->format('Y-m-d H:i:s'),
                                    $registration->name,
                                    $registration->email,
                                    "'" . $registration->phone,
                                    $registration->institution,
                                    $registration->address,
                                    $registration->payment_method,
                                    $registration->payment_url,
                                    'pending'
                                ]
                            ]
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Sheets Error: ' . $e->getMessage());
        }

        // 5. Redirect dengan Pesan Sukses
        return redirect()->route('registration.success');
    }

    private function getAccessToken($credentials)
    {
        $now = time();
        $payload = [
            'iss' => $credentials['client_email'],
            'sub' => $credentials['client_email'],
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
            'scope' => 'https://www.googleapis.com/auth/spreadsheets'
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, $credentials['private_key'], 'RS256');

        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]);

        return $response->json()['access_token'] ?? null;
    }

    /**
     * Menampilkan Halaman Sukses Pendaftaran
     */
    public function success()
    {
        return view('registrations.success');
    }
}