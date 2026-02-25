<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedpartPackageDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(MedpartPackage::class, 'medpart_package_id');
    }
}
