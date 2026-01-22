<?php

namespace App\Livewire\Fungsio;

use Livewire\Component;
use App\Models\Comite;
use App\Models\ComiteSie;
use App\Models\ComiteMember;
use App\Models\Fungsio;
use Illuminate\Support\Facades\Auth;

class ComiteMembers extends Component
{
    public $comiteId;

    public function mount($comiteId)
    {
        $this->comiteId = $comiteId;
    }

    public function render()
    {
        $comite = Comite::with(['sies.members.fungsio.user'])
            ->findOrFail($this->comiteId);

        // Get IDs currently in committee to filter them out of available list
        $existingIds = $comite->sies->flatMap(function ($s) {
            return $s->members->pluck('fungsio_id');
        })->unique()->values()->all();

        $availableFungsios = Fungsio::with('user')
            ->where('status', 'aktif')
            ->whereNotIn('id', $existingIds)
            ->get()
            ->sortBy('user.name')
            ->map(function ($f) {
                return [
                    'id' => $f->id,
                    'name' => $f->user->name ?? $f->nickname ?? 'Fungsio #' . $f->id,
                    'nickname' => $f->nickname
                ];
            })
            ->values();

        return view('livewire.fungsio.comite-members', [
            'comite' => $comite,
            'availableFungsios' => $availableFungsios
        ]);
    }

    public function addMember($sieId, $fungsioId, $role)
    {
        // 1. Authorize (Check if owner) - skipping exact check policy for speed, 
        // relying on the fact that only owner accesses this page usually, 
        // but better add simple check.
        $fungsio = $this->getCurrentFungsio();
        $comite = Comite::where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->find($this->comiteId);

        if (!$comite) {
            $this->dispatch('notify', message: 'Tidak dapat mengubah data kepanitiaan ini.', type: 'error');
            return;
        }

        $sie = ComiteSie::where('comite_id', $comite->id)->find($sieId);
        if (!$sie)
            return;

        // Validation Logic
        $memberCount = $sie->members()->count();
        $hasKoor = $sie->members()->where('role', 'koor')->exists();

        // Check if user is already in any sie of this comite (double check)
        $inOtherSie = ComiteMember::where('comite_id', $comite->id)
            ->where('fungsio_id', $fungsioId)
            ->exists();

        if ($inOtherSie) {
            $this->dispatch('notify', message: 'Fungsio sudah terdaftar di sie lain.', type: 'error');
            return;
        }

        if ($sie->name === 'Ketua Panitia') {
            if ($memberCount > 0) {
                $this->dispatch('notify', message: 'Ketua Panitia sudah terisi.', type: 'error');
                return;
            }
            $role = 'ketua';
        } elseif (in_array($sie->name, ['Penanggung Jawab', 'Steering Committee'])) {
            $role = 'anggota'; // Force anggota
        } else {
            // Regular Sie
            if ($role === 'koor' && $hasKoor) {
                $this->dispatch('notify', message: 'Sie ini sudah memiliki koordinator.', type: 'error');
                return;
            }
        }

        ComiteMember::create([
            'comite_id' => $comite->id,
            'comite_sie_id' => $sie->id,
            'fungsio_id' => $fungsioId,
            'role' => $role,
        ]);

        $this->dispatch('notify', message: 'Anggota berhasil ditambahkan.', type: 'success');
    }

    public function removeMember($memberId)
    {
        $fungsio = $this->getCurrentFungsio();
        $comite = Comite::where('created_by_fungsio_id', $fungsio->id)
            ->whereIn('status', ['draft', 'pending'])
            ->find($this->comiteId);

        if (!$comite)
            return;

        $member = ComiteMember::where('comite_id', $comite->id)->find($memberId);
        if ($member) {
            $member->delete();
            $this->dispatch('notify', message: 'Anggota berhasil dihapus.', type: 'success');
        }
    }

    protected function getCurrentFungsio()
    {
        $user = Auth::user();
        return Fungsio::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->orderByDesc('id')
            ->firstOrFail();
    }
}
