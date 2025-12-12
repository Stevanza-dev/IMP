<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WorkProgram;
use App\Models\Division;
use Illuminate\Http\Request;

class WorkProgramController extends Controller
{
    public function index()
    {
        $programs = WorkProgram::with('division')->latest('execution_date')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.programs.form', compact('divisions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'execution_date' => 'required|date',
            'is_active' => 'boolean',
        ]);
        // Trik checkbox: jika tidak dicentang, value tidak terkirim, jadi default 0
        $data['is_active'] = $request->has('is_active');

        WorkProgram::create($data);
        return redirect()->route('programs.index')->with('success', 'Proker berhasil ditambahkan');
    }

    public function edit($id)
    {
        $program = WorkProgram::findOrFail($id);
        $divisions = Division::all();
        return view('admin.programs.form', compact('program', 'divisions'));
    }

    public function update(Request $request, $id)
    {
        $program = WorkProgram::findOrFail($id);
        $data = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'execution_date' => 'required|date',
            'is_active' => 'sometimes',
        ]);
        $data['is_active'] = $request->has('is_active');

        $program->update($data);
        return redirect()->route('programs.index')->with('success', 'Proker berhasil diupdate');
    }

    public function destroy($id)
    {
        WorkProgram::destroy($id);
        return back()->with('success', 'Proker dihapus');
    }
}