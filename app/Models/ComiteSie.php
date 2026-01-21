<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComiteSie extends Model
{
    protected $fillable = [
        'comite_id',
        'name',
    ];

    public function comite()
    {
        return $this->belongsTo(Comite::class);
    }

    public function members()
    {
        return $this->hasMany(ComiteMember::class);
    }
}
