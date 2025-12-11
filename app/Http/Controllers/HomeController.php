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
}
