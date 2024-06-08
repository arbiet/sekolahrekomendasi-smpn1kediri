<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_target_id',
        'facility_name',
        'facility_description',
    ];

    /**
     * Get the school target that owns the facility.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
