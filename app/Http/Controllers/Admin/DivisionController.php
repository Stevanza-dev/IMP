<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();
        return view('admin.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('admin.divisions.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('divisions', 'public');
        }

        Division::create($data);
        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil ditambahkan');
    }

    public function edit(Division $division)
    {
        return view('admin.divisions.form', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($division->logo)
                Storage::disk('public')->delete($division->logo);
            $data['logo'] = $request->file('logo')->store('divisions', 'public');
        }

        $division->update($data);
        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil diupdate');
    }

    public function destroy(Division $division)
    {
        if ($division->logo)
            Storage::disk('public')->delete($division->logo);
        $division->delete();
        return back()->with('success', 'Divisi dihapus');
    }
}