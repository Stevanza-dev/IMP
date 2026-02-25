<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedpartPackage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(MedpartPackageDetail::class, 'medpart_package_id');
    }

    public function requirements()
    {
        return $this->hasMany(MedpartPackageDetail::class, 'medpart_package_id')->where('type', 'requirement');
    }

    public function feedbacks()
    {
        return $this->hasMany(MedpartPackageDetail::class, 'medpart_package_id')->where('type', 'feedback');
    }
}
