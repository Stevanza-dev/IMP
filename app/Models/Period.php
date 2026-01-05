<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'tahun',
    ];

    // Satu periode bisa punya banyak fungsio
    public function fungsios()
    {
        return $this->hasMany(Fungsio::class);
    }

    // Satu periode bisa punya banyak program kerja
    public function workPrograms()
    {
        return $this->hasMany(WorkProgram::class);
    }
}
