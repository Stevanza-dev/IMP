<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat data dummy panitia
        $divisions = ['Inti', 'Acara', 'Humas', 'Perkap', 'Konsumsi', 'Keamanan'];
        
        foreach(range(1, 20) as $i) {
            \App\Models\Member::create([
                'name' => 'Panitia ' . $i,
                'division' => $divisions[array_rand($divisions)]
            ]);
        }
    }
}
