<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedpartStep;
use Illuminate\Http\Request;

class MedpartStepController extends Controller
{
    public function index()
    {
        $steps = MedpartStep::orderBy('order_number')->get();
        return view('admin.medpart_step.index', compact('steps'));
    }

    public function create()
    {
        return view('admin.medpart_step.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_number' => 'required|integer',
            'description' => 'required|string',
            'is_active' => 'boolean'
        ]);

        MedpartStep::create([
            'order_number' => $request->order_number,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('medpart-steps.index')->with('success', 'Langkah sistematika berhasil ditambahkan!');
    }

    public function show(MedpartStep $medpartStep)
    {
        return redirect()->route('medpart-steps.index');
    }

    public function edit(MedpartStep $medpartStep)
    {
        return view('admin.medpart_step.edit', compact('medpartStep'));
    }

    public function update(Request $request, MedpartStep $medpartStep)
    {
        $request->validate([
            'order_number' => 'required|integer',
            'description' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $medpartStep->update([
            'order_number' => $request->order_number,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('medpart-steps.index')->with('success', 'Langkah sistematika berhasil diperbarui!');
    }

    public function destroy(MedpartStep $medpartStep)
    {
        $medpartStep->delete();
        return redirect()->route('medpart-steps.index')->with('success', 'Langkah ditambahkan terhapus!');
    }
}
