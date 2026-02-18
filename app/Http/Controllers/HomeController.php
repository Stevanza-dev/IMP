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
        $divisions = Division::with(['workPrograms' => function($query) {
            // Opsional: Urutkan proker berdasarkan tanggal pelaksanaan
            $query->orderBy('execution_date', 'asc');
        }])->get();

        // Data sosmed untuk footer (jika footer memerlukannya)
        $socials = SocialMedia::all();

        return view('guest.about', compact('divisions', 'socials'));
    }

    public function activity()
    {
        // Ambil data proker, urutkan dari yang tanggalnya paling depan (Upcoming) ke lama
        // Atau 'desc' jika ingin yang terbaru/masa depan di paling atas
        $activities = WorkProgram::with('division')
                        ->orderBy('execution_date', 'desc') 
                        ->get();

        $socials = SocialMedia::all();

        return view('guest.activity', compact('activities', 'socials'));
    }

    public function ampera()
    {
        // Cari data program kerja AMPERA 2026 di database
        // Kita pakai 'firstOrFail' agar jika data belum di-seeding, akan error 404 (aman)
        $amperaData = WorkProgram::where('name', 'LIKE', '%AMPERA%')->first();
        
        // Data sosmed untuk footer
        $socials = SocialMedia::all();

        return view('guest.ampera', compact('amperaData', 'socials'));
    }

    public function sisemar()
    {
        $sisemarData = WorkProgram::where('name', 'LIKE', '%SI SEMAR%')->first();

        // Data sosmed untuk footer
        $socials = SocialMedia::all();

        return view('guest.sisemar', compact('sisemarData', 'socials'));
    }

    public function sosmed()
    {
        // Ambil semua data social media dari database
        $socials = SocialMedia::all();

        return view('guest.sosmed', compact('socials'));
    }

    public function impcup()
    {
        // $impcupData = WorkProgram::where('name', 'LIKE', '%IMP Cup%')->first();

        // Data sosmed untuk footer
        $socials = SocialMedia::all();

        return view('guest.impcup', compact('socials'));
    }

    public function album()
    {
        // $albumData = WorkProgram::where('name', 'LIKE', '%Album%')->first();

        // Data sosmed untuk footer
        $socials = SocialMedia::all();

        return view('guest.album', compact('socials'));
    }
}
