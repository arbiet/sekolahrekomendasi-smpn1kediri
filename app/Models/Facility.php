<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_school_id',
        'facility_name',
        'facility_description',
    ];

    public function targetSchool()
    {
        return $this->belongsTo(SchoolTarget::class);
    }
}
