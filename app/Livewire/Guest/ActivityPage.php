<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkProgram;
use App\Models\SocialMedia;

#[Layout('components.layouts.guest')]
class ActivityPage extends Component
{
    public $activities;
    public $socials;

    public function mount()
    {
        // Ambil data proker, urutkan dari yang tanggalnya paling depan
        $this->activities = WorkProgram::with('division')
                        ->orderBy('execution_date', 'desc') 
                        ->get();

        // Data sosmed untuk footer
        $this->socials = SocialMedia::all();
    }

    public function render()
    {
        return view('livewire.guest.activity-page');
    }
}
