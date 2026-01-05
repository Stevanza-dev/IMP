<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = Period::orderBy('tahun', 'desc')->paginate(10);

        return view('admin.periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.periods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => ['required', 'string', 'max:50', 'unique:periods,tahun'],
        ]);

        Period::create($validated);

        return redirect()->route('periods.index')->with('status', 'Periode berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Period $period)
    {
        return redirect()->route('periods.edit', $period);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Period $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Period $period)
    {
        $validated = $request->validate([
            'tahun' => ['required', 'string', 'max:50', 'unique:periods,tahun,' . $period->id],
        ]);

        $period->update($validated);

        return redirect()->route('periods.index')->with('status', 'Periode berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        $period->delete();

        return redirect()->route('periods.index')->with('status', 'Periode berhasil dihapus.');
    }
}
