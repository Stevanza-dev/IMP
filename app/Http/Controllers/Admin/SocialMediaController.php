<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socials = SocialMedia::all();
        return view('admin.socials.index', compact('socials'));
    }

    public function create()
    {
        return view('admin.socials.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'url' => 'required|url',
            'icon_class' => 'required|string', // Contoh: fab fa-instagram
        ]);
        SocialMedia::create($data);
        return redirect()->route('socials.index')->with('success', 'Sosmed berhasil ditambahkan');
    }

    public function edit(SocialMedia $social)
    {
        return view('admin.socials.form', compact('social'));
    }

    public function update(Request $request, SocialMedia $social)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'url' => 'required|url',
            'icon_class' => 'required|string',
        ]);
        $social->update($data);
        return redirect()->route('socials.index')->with('success', 'Sosmed berhasil diupdate');
    }

    public function destroy(SocialMedia $social)
    {
        $social->delete();
        return back()->with('success', 'Sosmed dihapus');
    }
}