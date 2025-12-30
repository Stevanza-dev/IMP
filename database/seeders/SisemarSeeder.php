<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sisemar;
use Illuminate\Support\Str;

class SisemarSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            'SMA Negeri 1 Surabaya',
            'SMA Negeri 2 Surabaya',
            'SMA Negeri 3 Surabaya',
            'SMA Katolik St. Louis 1',
            'SMA Kristen Petra 1',
        ];

        $majors = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Elektro',
            'Teknik Mesin',
            'Teknik Sipil',
            'Arsitektur',
            'Desain Komunikasi Visual',
        ];

        // Buat 2 data dummy
        for ($i = 1; $i <= 2; $i++) {
            $status = ['pending', 'confirmed', 'rejected'][array_rand(['pending', 'confirmed', 'rejected'])];
            $eTicket = $status === 'confirmed' ? 'SISEMAR2026-' . strtoupper(Str::random(8)) : null;
            
            // Beberapa peserta sudah check-in
            $checkedIn = ($status === 'confirmed' && rand(0, 1)) ? now()->subHours(rand(1, 5)) : null;

            Sisemar::create([
                'email' => "stevanza{$i}@gmail.com",
                'name' => "Peserta SI SEMAR {$i}",
                'school' => $schools[array_rand($schools)],
                'wa_number' => '08' . rand(1000000000, 9999999999),
                'major_preference_1' => $majors[array_rand($majors)],
                'major_preference_2' => $majors[array_rand($majors)],
                'free_consultation' => ['Iya', 'Tidak'][array_rand(['Iya', 'Tidak'])],
                'payment' => ['Transfer BCA', 'Transfer Mandiri', 'GoPay', 'OVO'][array_rand(['Transfer BCA', 'Transfer Mandiri', 'GoPay', 'OVO'])],
                'payment_status' => ['DP', 'LUNAS'][array_rand(['DP', 'LUNAS'])],
                'status' => $status,
                'e_ticket_code' => $eTicket,
                'checked_in_at' => $checkedIn,
            ]);
        }
    }
}
