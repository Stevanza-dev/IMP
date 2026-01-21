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
            $sies = array_filter($validated['sies'], function($sieName) {
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
        $availableFungsios = Fungsio::where('status', 'aktif')
            ->orderBy('nickname')
            ->orderBy('id')
            ->get();

        return view('fungsio.comite-show', compact('comite', 'fungsio', 'availableFungsios'));
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
            $newSieNames = array_filter($validated['sies'], function($sieName) {
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

        if (! $isChair) {
            return back()->with('error', 'Hanya ketua panitia yang dapat memverifikasi kepanitiaan ini.');
        }

        $comite->status = 'approved';
        $comite->verified_by_fungsio_id = $fungsio->id;
        $comite->verified_at = now();
        $comite->save();

        return back()->with('success', 'Kepanitiaan berhasil diverifikasi oleh ketua panitia.');
    }

    /**
     * Tambah anggota ke salah satu sie dalam kepanitiaan.
     */
    public function storeMember(Request $request, string $comiteId)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->findOrFail($comiteId);

        $validated = $request->validate([
            'comite_sie_id' => ['required', 'exists:comite_sies,id'],
            'koor_id' => ['nullable', 'exists:fungsios,id'],
            'anggota_ids' => ['nullable', 'array'],
            'anggota_ids.*' => ['required', 'exists:fungsios,id'],
        ]);

        $koorId = $validated['koor_id'] ?? null;
        $anggotaIds = isset($validated['anggota_ids']) ? array_unique($validated['anggota_ids']) : [];

        // Pastikan sie milik comite ini
        $sie = ComiteSie::where('comite_id', $comite->id)
            ->findOrFail($validated['comite_sie_id']);

        // Ketentuan per sie:
        // - "Ketua Panitia": hanya 1 orang, disimpan dengan role khusus "ketua"
        // - "Penanggung Jawab" & "Steering Committee": tidak ada koor, semua sebagai anggota
        // - Sie lainnya: boleh ada koor (maksimal 1) dan anggota

        $sieName = $sie->name;

        // Fungsionaris yang sudah terdaftar di sie manapun dalam komite ini
        $assignedFungsioIds = $comite->sies
            ->flatMap(function ($s) {
                return $s->members;
            })
            ->pluck('fungsio_id')
            ->unique()
            ->toArray();

        // Tidak boleh ada duplikasi antara koor dan anggota dalam satu submit
        if ($koorId) {
            $anggotaIds = array_filter($anggotaIds, function ($id) use ($koorId) {
                return (int) $id !== (int) $koorId;
            });
        }

        if ($sieName === 'Ketua Panitia') {
            // Hanya satu orang diperbolehkan dalam sie ini
            if ($sie->members()->count() > 0) {
                return back()->with('error', 'Ketua Panitia hanya boleh diisi oleh satu orang.');
            }

            if (! $koorId) {
                return back()->with('error', 'Pilih satu fungsionaris sebagai Ketua Panitia.');
            }

            if (in_array($koorId, $assignedFungsioIds, true)) {
                return back()->with('error', 'Fungsionaris yang dipilih sudah terdaftar di sie lain.');
            }

            ComiteMember::create([
                'comite_id' => $comite->id,
                'comite_sie_id' => $sie->id,
                'fungsio_id' => $koorId,
                'role' => 'ketua',
            ]);
        } elseif (in_array($sieName, ['Penanggung Jawab', 'Steering Committee'])) {
            if (empty($anggotaIds)) {
                return back()->with('error', 'Pilih minimal satu anggota untuk sie ' . $sieName . '.');
            }

            foreach ($anggotaIds as $anggotaId) {
                if (in_array($anggotaId, $assignedFungsioIds, true)) {
                    continue; // lewati jika sudah terdaftar di sie lain
                }

                ComiteMember::create([
                    'comite_id' => $comite->id,
                    'comite_sie_id' => $sie->id,
                    'fungsio_id' => $anggotaId,
                    'role' => 'anggota',
                ]);
            }
        } else {
            // Sie lain: boleh ada koor (maksimal 1) dan beberapa anggota
            if ($koorId) {
                $hasKoor = $sie->members()->where('role', 'koor')->exists();

                if ($hasKoor) {
                    return back()->with('error', 'Sie ini sudah memiliki satu koor. Tidak dapat menambah koor lagi.');
                }

                if (in_array($koorId, $assignedFungsioIds, true)) {
                    return back()->with('error', 'Fungsionaris yang dipilih sebagai koor sudah terdaftar di sie lain.');
                }
            }

            if (! $koorId && empty($anggotaIds)) {
                return back()->with('error', 'Belum ada koor atau anggota yang dipilih untuk sie ini.');
            }

            if ($koorId) {
                ComiteMember::create([
                    'comite_id' => $comite->id,
                    'comite_sie_id' => $sie->id,
                    'fungsio_id' => $koorId,
                    'role' => 'koor',
                ]);

                $assignedFungsioIds[] = (int) $koorId;
            }

            foreach ($anggotaIds as $anggotaId) {
                if (in_array($anggotaId, $assignedFungsioIds, true)) {
                    continue; // lewati jika sudah terdaftar di sie lain / sebagai koor
                }

                ComiteMember::create([
                    'comite_id' => $comite->id,
                    'comite_sie_id' => $sie->id,
                    'fungsio_id' => $anggotaId,
                    'role' => 'anggota',
                ]);
            }
        }

        return back()->with('success', 'Anggota berhasil disimpan.');
    }

    /**
     * Hapus anggota dari sie dalam kepanitiaan.
     */
    public function destroyMember(string $comiteId, string $memberId)
    {
        $fungsio = $this->getCurrentFungsio();

        $comite = Comite::where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->findOrFail($comiteId);

        $member = ComiteMember::where('comite_id', $comite->id)
            ->findOrFail($memberId);

        $member->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
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
