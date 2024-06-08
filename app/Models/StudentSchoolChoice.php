<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchoolChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_choice',
        'second_choice',
        'third_choice',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
