<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sisemar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'email',
        'name',
        'school',
        'wa_number',
        'major_preference_1',
        'major_preference_2',
        'free_consultation',
        'payment',
        'payment_status',
        'status',
        'e_ticket_code',
        'physical_ticket_code',
        'ticket_redeemed_at',
        'checked_in_at',
    ];

    protected $casts = [
        'ticket_redeemed_at' => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    // Helper Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function hasRedeemedTicket(): bool
    {
        return !is_null($this->ticket_redeemed_at);
    }

    public function hasCheckedIn(): bool
    {
        return !is_null($this->checked_in_at);
    }
}