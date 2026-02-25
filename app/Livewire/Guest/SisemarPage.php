<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkProgram;
use App\Models\SocialMedia;

#[Layout('components.layouts.guest')]
class SisemarPage extends Component
{
    public $sisemarData;
    public $socials;

    public function mount()
    {
        // Cari data program kerja SI SEMAR
        $this->sisemarData = WorkProgram::where('name', 'LIKE', '%SI SEMAR%')->first();

        // Data sosmed untuk footer
        $this->socials = SocialMedia::all();
    }

    public function render()
    {
        return view('livewire.guest.sisemar-page');
    }
}
