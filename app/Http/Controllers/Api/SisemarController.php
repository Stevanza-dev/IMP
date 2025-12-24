<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sisemar;

class SisemarController extends Controller
{
    public function storeFromSpreadsheet(Request $request)
    {

        // 1. Validasi Sederhana (Opsional)
        // Pastikan request memiliki data yang dibutuhkan
        if (!$request->has(['email', 'name'])) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak lengkap'], 400);
        }

        // 2. Simpan ke Database
        // Kita pakai updateOrCreate berdasarkan 'email'.
        // Jadi kalau email sudah ada, data nama & sekolah akan di-update.
        // Kalau belum ada, akan dibuat baru.
        try {
            $data = Sisemar::updateOrCreate(
                ['email' => $request->email], // Kunci unik
                [
                    'name' => $request->name,
                    'school' => $request->school,
                    'payment' => $request->payment,
                    'payment_status' => $request->payment_status ?? 'DP',
                    'wa_number' => $request->wa_number,
                    'major_preference_1' => $request->major_preference_1,
                    'major_preference_2' => $request->major_preference_2,
                    'free_consultation' => $request->free_consultation ?? 'Tidak',
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
