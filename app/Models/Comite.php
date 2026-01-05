<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comite extends Model
{
    protected $fillable = [
        'work_program_id',
        'fungsio_id',
        'sie',
    ];

    public function workProgram()
    {
        return $this->belongsTo(WorkProgram::class);
    }

    public function fungsio()
    {
        return $this->belongsTo(Fungsio::class);
    }
}
