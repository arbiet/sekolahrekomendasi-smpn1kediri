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

    public function finalScore()
    {
        return $this->hasOne(StudentFinalScore::class);
    }

    public function schoolChoice()
    {
        return $this->hasOne(StudentSchoolChoice::class);
    }

    public function graduatedSchool()
    {
        return $this->hasOne(StudentGraduatedSchool::class);
    }

    public function getAverageScoreAttribute()
    {
        if ($this->finalScore) {
            $totalScore = $this->finalScore->mathematics
                         + $this->finalScore->science
                         + $this->finalScore->english
                         + $this->finalScore->indonesian
                         + $this->finalScore->civics
                         + $this->finalScore->religion
                         + $this->finalScore->physical_education
                         + $this->finalScore->arts_and_crafts
                         + $this->finalScore->local_content;

            return $totalScore / 9;
        }

        return null;
    }

    public function hasAchievement()
    {
        return $this->achievements->isNotEmpty();
    }
}
