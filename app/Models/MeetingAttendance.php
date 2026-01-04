<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingAttendance extends Model
{
    protected $fillable = [
        'meeting_id',
        'member_id',
        'check_in_at',
        'distance_in_meters',
        'status',
        'notes',
        'photo_public_id',
        'photo_url',
    ];

    // Relasi balik ke Member (agar kita tahu ini absennya siapa)
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}