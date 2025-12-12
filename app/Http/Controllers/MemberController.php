<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SocialMedia;

class MemberController extends Controller
{
    public function index()
    {
        // Ambil semua member, urutkan nama, lalu GRUPKAN berdasarkan nama divisi
        // Hasilnya: ['Sie Acara' => [Member A, Member B], 'Sie Humas' => [Member C]...]
        $groupedMembers = Member::orderBy('name')->get()->groupBy('division');

        // Urutkan key (nama divisi) agar abjad
        $groupedMembers = $groupedMembers->sortKeys();

        // Data sosmed untuk footer
        $socials = SocialMedia::all();

        return view('members.index', compact('groupedMembers', 'socials'));
    }
}