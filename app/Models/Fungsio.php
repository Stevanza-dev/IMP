<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fungsio extends Model
{
    protected $fillable = [
        'user_id',
        'division_id',
        'period_id',
        'nickname',
        'nim',
        'jabatan',
        'year',
        'foto_public',
        'foto_url',
        'no_hp',
        'alamat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function comites()
    {
        return $this->hasMany(Comite::class, 'created_by_fungsio_id');
    }
}
