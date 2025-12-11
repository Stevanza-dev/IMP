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
        // Ambil semua sosmed
        $socials = SocialMedia::all();

        // Ambil Divisi beserta Prokernya (Eager Loading biar cepat)
        $divisions = Division::with('workPrograms')->get();

        // Ambil Proker Unggulan (misal yang akan datang)
        $upcomingProkers = WorkProgram::where('execution_date', '>', now())
                            ->orderBy('execution_date', 'asc')
                            ->take(3)
                            ->get();

        return view('guest.home', compact('socials', 'divisions', 'upcomingProkers'));
    }
}
