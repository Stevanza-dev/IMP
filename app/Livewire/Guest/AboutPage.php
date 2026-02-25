<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Division;
use App\Models\SocialMedia;

#[Layout('components.layouts.guest')]
class AboutPage extends Component
{
    public $divisions;
    public $socials;

    public function mount()
    {
        // Ambil semua divisi beserta program kerjanya
        $this->divisions = Division::with(['workPrograms' => function($query) {
            $query->orderBy('execution_date', 'asc');
        }])->get();

        // Data sosmed untuk footer
        $this->socials = SocialMedia::all();
    }

    public function render()
    {
        return view('livewire.guest.about-page');
    }
}
