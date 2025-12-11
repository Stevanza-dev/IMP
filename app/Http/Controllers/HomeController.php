<?php

namespace App\Http\Controllers;
use App\Models\Division;
use App\Models\WorkProgram;
use App\Models\SocialMedia;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data sosmed untuk footer
        $socials = SocialMedia::all();

        // Ambil 3 Proker unggulan/terbaru untuk ditampilkan di Home
        $programs = WorkProgram::latest()->take(3)->get();

        return view('guest.home', compact('socials', 'programs'));
    }

    public function about()
    {
        // Ambil semua divisi beserta program kerjanya
        // Urutkan divisi berdasarkan nama (atau ID jika ingin urut sesuai input)
        $divisions = \App\Models\Division::with(['workPrograms' => function($query) {
            // Opsional: Urutkan proker berdasarkan tanggal pelaksanaan
            $query->orderBy('execution_date', 'asc');
        }])->get();

        // Data sosmed untuk footer (jika footer memerlukannya)
        $socials = \App\Models\SocialMedia::all();

        return view('guest.about', compact('divisions', 'socials'));
    }

    public function activity()
    {
        // Ambil data proker, urutkan dari yang tanggalnya paling depan (Upcoming) ke lama
        // Atau 'desc' jika ingin yang terbaru/masa depan di paling atas
        $activities = \App\Models\WorkProgram::with('division')
                        ->orderBy('execution_date', 'desc') 
                        ->get();

        $socials = \App\Models\SocialMedia::all();

        return view('guest.activity', compact('activities', 'socials'));
    }
}
