<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComiteMember extends Model
{
    protected $fillable = [
        'comite_id',
        'comite_sie_id',
        'fungsio_id',
        'role',
    ];

    public function comite()
    {
        return $this->belongsTo(Comite::class);
    }

    public function sie()
    {
        return $this->belongsTo(ComiteSie::class, 'comite_sie_id');
    }

    public function fungsio()
    {
        return $this->belongsTo(Fungsio::class);
    }
}
