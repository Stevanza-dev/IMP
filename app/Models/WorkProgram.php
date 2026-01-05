<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProgram extends Model
{
    protected $guarded = [];
    
    // Proker ini MILIK satu Divisi
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
        return $this->hasMany(Comite::class);
    }
}
