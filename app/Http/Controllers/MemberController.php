<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        // Grupkan berdasarkan Sie agar rapi
        $groupedMembers = Member::orderBy('division')->orderBy('name')->get()->groupBy('division');
        $groupedMembers = $groupedMembers->sortKeys();

        return view('members.index', compact('groupedMembers'));
    }

    public function create()
    {
        // DAFTAR DIVISI KHUSUS PANITIA AMPERA
        $divisions = [
            'Penanggung Jawab',
            'Steering Committee (SC)',
            'Sekretaris',
            'Bendahara',
            'Sie Acara',
            'Sie Humas',
            'Sie Konsumsi',
            'Sie PDD',
            'Sie Sponsor',
            'Sie Perkap',
        ];

        return view('members.form', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|string|max:255',
        ]);

        Member::create($request->only('name', 'division'));

        return redirect()->route('members.index')->with('success', 'Panitia berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        // Gunakan daftar yang sama untuk Edit
        $divisions = [
            'Penanggung Jawab',
            'Steering Committee (SC)',
            'Sekretaris',
            'Bendahara',
            'Sie Acara',
            'Sie Humas',
            'Sie Konsumsi',
            'Sie PDD',
            'Sie Sponsor',
            'Sie Perkap',
        ];

        return view('members.form', compact('member', 'divisions'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|string|max:255',
        ]);

        $member->update($request->only('name', 'division'));

        return redirect()->route('members.index')->with('success', 'Data panitia berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return back()->with('success', 'Panitia berhasil dihapus.');
    }
}