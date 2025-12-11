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
}
