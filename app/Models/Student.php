<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'batch_year',
        'class',
        'place_of_birth',
        'date_of_birth',
        'nisn',
        'phone_number',
        'email',
        'status',
    ];

    public function address()
    {
        return $this->hasOne(StudentAddress::class);
    }

    public function achievements()
    {
        return $this->hasMany(StudentAchievement::class);
    }

    public function finalScores()
    {
        return $this->hasMany(StudentFinalScore::class);
    }

    public function schoolChoices()
    {
        return $this->hasMany(StudentSchoolChoice::class);
    }

    public function graduatedSchool()
    {
        return $this->hasOne(StudentGraduatedSchool::class);
    }
}
