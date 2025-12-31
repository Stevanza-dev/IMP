<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Registration;

class RegistrationsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = '';

    // Simpan hanya search & filter di query string.
    protected $queryString = ['search', 'filter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // Initialize properties if needed
    }

    public function render()
    {
        $query = Registration::query();

        // Filter berdasarkan status
        if ($this->filter === 'confirmed') {
            $query->where('status', 'confirmed');
        } elseif ($this->filter === 'pending') {
            $query->where('status', 'pending');
        }

        // Pencarian berdasarkan nama
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        $registrations = $query->latest()->paginate(10);

        // Statistik
        $totalCount = Registration::count();
        $confirmedCount = Registration::where('status', 'confirmed')->count();
        $pendingCount = Registration::where('status', 'pending')->count();

        return view('livewire.registrations-table', compact('registrations', 'totalCount', 'confirmedCount', 'pendingCount'));
    }
}
