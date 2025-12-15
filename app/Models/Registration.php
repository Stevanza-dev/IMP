<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Field yang boleh diisi oleh user/admin
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'institution',
        'payment_method',
        'payment_proof',
        'payment_url',
        'ticket_code',
        'status',
        'checked_in_at',
    ];

    // Konversi otomatis tipe data
    protected $casts = [
        'checked_in_at' => 'datetime',
    ];
}