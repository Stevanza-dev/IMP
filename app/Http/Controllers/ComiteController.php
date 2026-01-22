<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comite;
use App\Models\WorkProgram;
use App\Models\Fungsio;
use App\Models\ComiteSie;
use App\Models\ComiteMember;
use Illuminate\Support\Facades\Auth;

class ComiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fungsio = $this->getCurrentFungsio();

        // Kepanitiaan yang dibuat oleh fungsio ini
        $comites = Comite::with('workProgram')
            ->where('created_by_fungsio_id', $fungsio->id)
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'created_page');

        // Kepanitiaan yang diikuti fungsio ini sebagai anggota/panitia
        $joinedComites = Comite::with(['workProgram', 'sies.members'])
            ->whereHas('members', function ($q) use ($fungsio) {
                $q->where('fungsio_id', $fungsio->id);
            })
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'joined_page');

        return view('fungsio.comite', compact('comites', 'joinedComites', 'fungsio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fungsio = $this->getCurrentFungsio();
        $workPrograms = WorkProgram::where('is_active', true)
            ->orderBy('execution_date')
            ->get();

        return view('fungsio.comite-create', compact('fungsio', 'workPrograms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fungsio = $this->getCurrentFungsio();

        $validated = $request->validate([
            'work_program_id' => ['required', 'exists:work_programs,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sies' => ['nullable', 'array'],
            'sies.*' => ['nullable', 'string', 'max:255'],
        ]);

        $workProgram = WorkProgram::findOrFail($validated['work_program_id']);

        $comite = Comite::create([
            'work_program_id' => $workProgram->id,
            'created_by_fungsio_id' => $fungsio->id,
            'title' => $validated['title'] ?? $workProgram->name . ' Committee',
            'description' => $validated['description'] ?? null,
            'status' => 'pending', // menunggu verifikasi
        ]);

        // Filter sie yang tidak kosong
        if (!empty($validated['sies'])) {
            $sies = array_filter($validated['sies'], function ($sieName) {
                return !empty(trim($sieName));
            });

            foreach ($sies as $sieName) {
                ComiteSie::create([
                    'comite_id' => $comite->id,
                    'name' => trim($sieName),
                ]);
            }
        }

        return redirect()
            ->route('fungsio.comite.index')
            ->with('success', 'Kepanitiaan berhasil dibuat dan menunggu verifikasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::with(['workProgram', 'sies.members.fungsio'])
            ->where('created_by_fungsio_id', $fungsio->id)
            ->findOrFail($id);

        // Daftar fungsio aktif (misalnya untuk dipilih sebagai anggota sie)
        return view('fungsio.comite-show', compact('comite', 'fungsio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::with('sies')
            ->where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->findOrFail($id);

        $workPrograms = WorkProgram::where('is_active', true)
            ->orderBy('execution_date')
            ->get();

        return view('fungsio.comite-edit', compact('comite', 'workPrograms', 'fungsio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::with('sies')
            ->where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->findOrFail($id);

        $validated = $request->validate([
            'work_program_id' => ['required', 'exists:work_programs,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sies' => ['nullable', 'array'],
            'sies.*' => ['nullable', 'string', 'max:255'],
        ]);

        $workProgram = WorkProgram::findOrFail($validated['work_program_id']);

        $comite->update([
            'work_program_id' => $workProgram->id,
            'title' => $validated['title'] ?? $workProgram->name . ' Committee',
            'description' => $validated['description'] ?? null,
        ]);

        // Update daftar sie dengan mempertahankan sie yang sama
        // Filter sie yang tidak kosong dari input
        $newSieNames = [];
        if (!empty($validated['sies'])) {
            $newSieNames = array_filter($validated['sies'], function ($sieName) {
                return !empty(trim($sieName));
            });
            $newSieNames = array_map('trim', $newSieNames);
        }

        // Ambil sie yang sudah ada
        $existingSies = $comite->sies;
        $existingSieNames = $existingSies->pluck('name', 'id')->toArray();

        // 1. Hapus sie yang tidak ada di input baru (sie yang dihapus user)
        foreach ($existingSies as $existingSie) {
            if (!in_array($existingSie->name, $newSieNames)) {
                // Sie ini dihapus dari input, hapus dari database
                $existingSie->delete();
            }
        }

        // 2. Tambah sie baru yang belum ada di database
        foreach ($newSieNames as $newSieName) {
            if (!in_array($newSieName, $existingSieNames)) {
                // Sie baru, tambahkan ke database
                ComiteSie::create([
                    'comite_id' => $comite->id,
                    'name' => $newSieName,
                ]);
            }
            // Jika sie sudah ada dengan nama yang sama, tidak perlu update (biarkan tetap + anggotanya tetap)
        }

        return redirect()
            ->route('fungsio.comite.index')
            ->with('success', 'Kepanitiaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->findOrFail($id);

        $comite->delete();

        return redirect()
            ->route('fungsio.comite.index')
            ->with('success', 'Kepanitiaan berhasil dihapus.');
    }

    /**
     * Verifikasi kepanitiaan oleh ketua panitia yang terdaftar di kepanitiaan.
     */
    public function verify(string $id)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::with('members')
            ->where('status', 'pending')
            ->findOrFail($id);

        // Hanya ketua panitia (role "ketua" pada sie "Ketua Panitia") yang boleh verifikasi
        $isChair = $comite->members()
            ->where('fungsio_id', $fungsio->id)
            ->whereIn('role', ['ketua', 'koor'])
            ->whereHas('sie', function ($q) {
                $q->where('name', 'Ketua Panitia');
            })
            ->exists();

        if (!$isChair) {
            return back()->with('error', 'Hanya ketua panitia yang dapat memverifikasi kepanitiaan ini.');
        }

        $comite->status = 'approved';
        $comite->verified_by_fungsio_id = $fungsio->id;
        $comite->verified_at = now();
        $comite->save();

        return back()->with('success', 'Kepanitiaan berhasil diverifikasi oleh ketua panitia.');
    }



    /**
     * Detail kepanitiaan untuk fungsio yang menjadi anggota.
     */
    public function myComiteShow(string $id)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::with(['workProgram', 'createdBy.user', 'verifiedBy.user', 'sies.members.fungsio.user'])
            ->whereHas('members', function ($q) use ($fungsio) {
                $q->where('fungsio_id', $fungsio->id);
            })
            ->findOrFail($id);

        return view('fungsio.comite-mydetail', compact('comite', 'fungsio'));
    }

    /**
     * Ambil Fungsio aktif untuk user saat ini.
     */
    protected function getCurrentFungsio(): Fungsio
    {
        $user = Auth::user();

        return Fungsio::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->orderByDesc('id')
            ->firstOrFail();
    }
}
