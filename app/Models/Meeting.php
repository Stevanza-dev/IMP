<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title', 'date', 'latitude', 'longitude', 'token', 'is_active'
    ];

    // Relasi: Satu rapat punya banyak kehadiran
    public function attendances()
    {
        return $this->hasMany(MeetingAttendance::class);
    }
}