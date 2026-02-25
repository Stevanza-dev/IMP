<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'name' => 'Sholikhan (Ketua Umum)',
            'phone' => '62895421689966',
        ]);

        Contact::create([
            'name' => 'Stevan (Kominfo)',
            'phone' => '6282323729900',
        ]);
    }
}
