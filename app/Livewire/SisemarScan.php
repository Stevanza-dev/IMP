<?php

namespace App\Livewire;

use App\Models\Sisemar;
use Livewire\Component;

class SisemarScan extends Component
{
    public $lastScannedCode;
    public $message;
    public $statusType; // success, error, warning
    public $scannedData; // Store basic info of scanned user

    public $isScanning = true;

    public function scan($code)
    {
        $this->lastScannedCode = $code;
        $this->message = null;
        $this->statusType = null;
        $this->scannedData = null;

        if (empty($code)) {
            return;
        }

        $sisemar = Sisemar::where('e_ticket_code', strtoupper($code))->first();

        // Default: stop scanning to show result
        $this->isScanning = false;

        if (!$sisemar) {
            $this->statusType = 'error';
            $this->message = 'E-Ticket tidak ditemukan! Pastikan peserta sudah terkonfirmasi.';
            return;
        }

        if (!$sisemar->isConfirmed()) {
            $this->statusType = 'error';
            $this->message = 'Pendaftaran belum disetujui. Status: ' . $sisemar->status;
            return;
        }

        if ($sisemar->hasCheckedIn()) {
            $this->statusType = 'warning';
            $this->message = 'Peserta sudah check-in pada ' . $sisemar->checked_in_at->format('d M Y H:i');
            $this->scannedData = [
                'name' => $sisemar->name,
                'email' => $sisemar->email,
                'school' => $sisemar->school,
            ];
            return;
        }

        // Catat absensi
        $sisemar->update([
            'checked_in_at' => now(),
        ]);

        $this->statusType = 'success';
        $this->message = 'Check-in berhasil! Selamat datang, ' . $sisemar->name;
        $this->scannedData = [
            'name' => $sisemar->name,
            'email' => $sisemar->email,
            'school' => $sisemar->school,
        ];
    }

    public function nextScan()
    {
        $this->isScanning = true;
        $this->message = null;
        $this->statusType = null;
        $this->scannedData = null;
        $this->lastScannedCode = null;

        $this->dispatch('start-scanner');
    }

    public function render()
    {
        return view('livewire.sisemar-scan');
    }
}
