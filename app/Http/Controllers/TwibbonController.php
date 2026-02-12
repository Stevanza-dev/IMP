<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwibbonController extends Controller
{
    public function index()
    {
        return view('twibbon.index');
    }
}
