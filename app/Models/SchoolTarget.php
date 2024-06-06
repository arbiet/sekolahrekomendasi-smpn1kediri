<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'accreditation',
        'website',
    ];

    /**
     * Get the facilities for the school target.
     */
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    /**
     * Get the academics for the school target.
     */
    public function academics()
    {
        return $this->hasMany(Academic::class);
    }

    /**
     * Get the extracurricular activities for the school target.
     */
    public function extracurriculars()
    {
        return $this->hasMany(Extracurricular::class);
    }
}
