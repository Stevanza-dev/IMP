<?php

namespace App\Livewire;

use App\Models\Sisemar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SisemarETicketMail;
use Livewire\Component;
use Livewire\WithPagination;

class SisemarModal extends Component
{
    use WithPagination;

    public $showApproveModal = false;
    public $showDeleteModal = false;
    public $showPaymentModal = false;
    public $selectedSisemar = null;

    protected $listeners = ['refreshSisemars' => '$refresh'];

    // Approve Modal
    public function openApproveModal($id)
    {
        $this->selectedSisemar = Sisemar::findOrFail($id);
        $this->showApproveModal = true;
    }

    public function closeApproveModal()
    {
        $this->showApproveModal = false;
        $this->selectedSisemar = null;
    }

    public function approveConfirm()
    {
        if (!$this->selectedSisemar || $this->selectedSisemar->status !== 'pending') {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Data tidak valid atau sudah diproses!']);
            $this->closeApproveModal();
            return;
        }

        // Generate E-Ticket Code
        $eTicketCode = 'SISEMAR2026-' . strtoupper(Str::random(8));

        $this->selectedSisemar->update([
            'status' => 'confirmed',
            'e_ticket_code' => $eTicketCode,
        ]);

        // Kirim Email E-Ticket
        Mail::to($this->selectedSisemar->email)->send(new SisemarETicketMail($this->selectedSisemar));

        session()->flash('success', 'Pendaftaran disetujui! E-Ticket telah dikirim ke ' . $this->selectedSisemar->email);

        $this->closeApproveModal();
        $this->resetPage();
    }

    // Delete Modal
    public function openDeleteModal($id)
    {
        $this->selectedSisemar = Sisemar::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->selectedSisemar = null;
    }

    public function deleteConfirm()
    {
        if (!$this->selectedSisemar) {
            session()->flash('error', 'Data tidak ditemukan!');
            $this->closeDeleteModal();
            return;
        }

        $name = $this->selectedSisemar->name;
        $this->selectedSisemar->delete();

        session()->flash('success', "Data peserta {$name} berhasil dihapus.");

        $this->closeDeleteModal();
        $this->resetPage();
    }

    // Payment Modal
    public function openPaymentModal($id)
    {
        $this->selectedSisemar = Sisemar::findOrFail($id);
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedSisemar = null;
    }

    public function updatePaymentStatus()
    {
        if (!$this->selectedSisemar) {
            session()->flash('error', 'Data tidak ditemukan!');
            $this->closePaymentModal();
            return;
        }

        $this->selectedSisemar->update([
            'payment_status' => 'LUNAS',
        ]);

        session()->flash('success', 'Status pembayaran berhasil diubah menjadi LUNAS!');

        $this->closePaymentModal();
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.sisemar-modal', [
            'sisemars' => Sisemar::latest()->paginate(20),
        ]);
    }
}
