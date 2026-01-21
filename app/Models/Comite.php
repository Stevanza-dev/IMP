<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comite extends Model
{
    protected $fillable = [
        'work_program_id',
        'created_by_fungsio_id',
        'verified_by_fungsio_id',
        'title',
        'description',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function workProgram()
    {
        return $this->belongsTo(WorkProgram::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Fungsio::class, 'created_by_fungsio_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(Fungsio::class, 'verified_by_fungsio_id');
    }

    public function sies()
    {
        return $this->hasMany(ComiteSie::class);
    }

    public function members()
    {
        return $this->hasMany(ComiteMember::class);
    }
}
