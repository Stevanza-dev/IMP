<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkProgram;
use App\Models\SocialMedia;

#[Layout('components.layouts.guest')]
class AmperaPage extends Component
{
    public $amperaData;
    public $socials;

    public function mount()
    {
        // Cari data program kerja AMPERA 2026 di database
        $this->amperaData = WorkProgram::where('name', 'LIKE', '%AMPERA%')->first();
        
        // Data sosmed untuk footer
        $this->socials = SocialMedia::all();
    }

    public function render()
    {
        return view('livewire.guest.ampera-page');
    }
}
