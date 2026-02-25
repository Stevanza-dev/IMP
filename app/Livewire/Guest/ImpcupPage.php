<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SocialMedia;

#[Layout('components.layouts.guest')]
class ImpcupPage extends Component
{
    public $socials;

    public function mount()
    {
        // Data sosmed untuk footer
        $this->socials = SocialMedia::all();
    }

    public function render()
    {
        return view('livewire.guest.impcup-page');
    }
}
