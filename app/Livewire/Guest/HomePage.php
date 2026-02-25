<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SocialMedia;
use App\Models\WorkProgram;
use App\Models\Contact;

#[Layout('components.layouts.guest')]
class HomePage extends Component
{
    public $socials;
    public $programs;
    public $ketuaUmum;

    public function mount()
    {
        // Ambil data sosmed untuk footer
        $this->socials = SocialMedia::all();

        // Ambil 3 Proker unggulan/terbaru untuk ditampilkan di Home
        $this->programs = WorkProgram::latest()->take(3)->get();

        // Data kontak Ketua Umum
        $this->ketuaUmum = Contact::find(1);
    }

    public function render()
    {
        return view('livewire.guest.home-page');
    }
}
