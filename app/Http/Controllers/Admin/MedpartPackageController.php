<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedpartPackage;
use Illuminate\Http\Request;

use App\Models\MedpartPackageDetail;

class MedpartPackageController extends Controller
{
    public function index()
    {
        $packages = MedpartPackage::with(['requirements', 'feedbacks'])->get();
        return view('admin.medpart_package.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.medpart_package.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'is_active' => 'boolean',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'feedbacks' => 'nullable|array',
            'feedbacks.*' => 'nullable|string',
        ]);

        $package = MedpartPackage::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->has('requirements')) {
            foreach ($request->requirements as $req) {
                if (!empty(trim($req))) {
                    MedpartPackageDetail::create([
                        'medpart_package_id' => $package->id,
                        'type' => 'requirement',
                        'content' => $req
                    ]);
                }
            }
        }

        if ($request->has('feedbacks')) {
            foreach ($request->feedbacks as $fb) {
                if (!empty(trim($fb))) {
                    MedpartPackageDetail::create([
                        'medpart_package_id' => $package->id,
                        'type' => 'feedback',
                        'content' => $fb
                    ]);
                }
            }
        }

        return redirect()->route('medpart-packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function show(MedpartPackage $medpartPackage)
    {
        return redirect()->route('medpart-packages.index');
    }

    public function edit(MedpartPackage $medpartPackage)
    {
        $medpartPackage->load(['requirements', 'feedbacks']);
        return view('admin.medpart_package.edit', compact('medpartPackage'));
    }

    public function update(Request $request, MedpartPackage $medpartPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'is_active' => 'boolean',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'feedbacks' => 'nullable|array',
            'feedbacks.*' => 'nullable|string',
        ]);

        $medpartPackage->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ]);

        // Hapus yang lama, insert yang baru untuk simpelnya
        MedpartPackageDetail::where('medpart_package_id', $medpartPackage->id)->delete();

        if ($request->has('requirements')) {
            foreach ($request->requirements as $req) {
                if (!empty(trim($req))) {
                    MedpartPackageDetail::create([
                        'medpart_package_id' => $medpartPackage->id,
                        'type' => 'requirement',
                        'content' => $req
                    ]);
                }
            }
        }

        if ($request->has('feedbacks')) {
            foreach ($request->feedbacks as $fb) {
                if (!empty(trim($fb))) {
                    MedpartPackageDetail::create([
                        'medpart_package_id' => $medpartPackage->id,
                        'type' => 'feedback',
                        'content' => $fb
                    ]);
                }
            }
        }

        return redirect()->route('medpart-packages.index')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(MedpartPackage $medpartPackage)
    {
        $medpartPackage->delete();
        return redirect()->route('medpart-packages.index')->with('success', 'Paket dihapus!');
    }
}
