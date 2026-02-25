<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SocialMedia;
use App\Models\MedpartStep;
use App\Models\MedpartPackage;
use App\Models\MedpartPayment;
use App\Models\Contact;

#[Layout('components.layouts.guest')]
class SosmedPage extends Component
{
    public $socials;
    public $medpartSteps;
    public $medpartPackages;
    public $medpartPayments;
    public $kominfo;

    public function mount()
    {
        // Ambil semua data social media dari database
        $this->socials = SocialMedia::all();

        // Data Medpart
        $this->medpartSteps = MedpartStep::where('is_active', true)->orderBy('order_number', 'asc')->get();
        $this->medpartPackages = MedpartPackage::with(['requirements', 'feedbacks'])->where('is_active', true)->get();
        $this->medpartPayments = MedpartPayment::where('is_active', true)->get();

        // Data kontak Kominfo
        $this->kominfo = Contact::find(2);
    }

    public function render()
    {
        return view('livewire.guest.sosmed-page');
    }
}
