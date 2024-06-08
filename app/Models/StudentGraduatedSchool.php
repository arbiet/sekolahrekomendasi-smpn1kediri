<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGraduatedSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'selected_school',
        'accepted_school',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
