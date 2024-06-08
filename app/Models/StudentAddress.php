<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'street',
        'subdistrict',
        'district',
        'city',
        'province',
        'postal_code',
        'location_type',
        'latitude',
        'longitude',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
