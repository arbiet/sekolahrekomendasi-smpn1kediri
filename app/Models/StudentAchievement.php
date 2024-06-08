<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'achievement_type',
        'activity_name',
        'level',
        'achievement',
        'achievement_year',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
