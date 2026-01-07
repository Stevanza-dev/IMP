<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    // Satu Divisi memiliki BANYAK Proker
    public function workPrograms()
    {
        return $this->hasMany(WorkProgram::class);
    }

    public function fungsios()
    {
        return $this->hasMany(Fungsio::class);
    }
}
