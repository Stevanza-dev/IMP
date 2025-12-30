<?php

namespace App\Http\Controllers;

class SisemarAdminController extends Controller
{
    // Dashboard: List semua pendaftar
    public function index()
    {
        return view('admin.sisemar.index');
    }
}