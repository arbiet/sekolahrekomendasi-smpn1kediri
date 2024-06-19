<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'accreditation',
        'website',
        'latitude',
        'longitude',
    ];

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function academics()
    {
        return $this->hasMany(Academic::class);
    }

    public function extracurriculars()
    {
        return $this->hasMany(Extracurricular::class);
    }

    public function graduatedStudents()
    {
        return $this->hasMany(StudentGraduatedSchool::class, 'accepted_school', 'name');
    }

    public function getAverageSchoolScoreAttribute()
    {
        $students = $this->graduatedStudents;
        if ($students->isEmpty()) {
            return null;
        }

        $totalScore = 0;
        $count = 0;

        foreach ($students as $graduatedStudent) {
            if ($graduatedStudent->student && $graduatedStudent->student->finalScore) {
                $totalScore += $graduatedStudent->student->average_score;
                $count++;
            }
        }

        return $count ? $totalScore / $count : null;
    }

    public function getLowestAcceptedScoreAttribute()
    {
        $students = $this->graduatedStudents;
        if ($students->isEmpty()) {
            return null;
        }

        $lowestScore = PHP_FLOAT_MAX;

        foreach ($students as $graduatedStudent) {
            if ($graduatedStudent->student && $graduatedStudent->student->finalScore) {
                $score = $graduatedStudent->student->average_score;
                if ($score < $lowestScore) {
                    $lowestScore = $score;
                }
            }
        }

        return $lowestScore === PHP_FLOAT_MAX ? null : $lowestScore;
    }

    public function getAcademicPathPercentageAttribute()
    {
        $students = $this->graduatedStudents;
        if ($students->isEmpty()) {
            return 0;
        }

        $academicCount = 0;
        $totalCount = $students->count();

        foreach ($students as $graduatedStudent) {
            if ($graduatedStudent->student && $graduatedStudent->student->hasAchievement()) {
                $academicCount++;
            }
        }

        $percentage = ($academicCount / $totalCount) * 100;
        return 100 - $percentage;
    }

    public function getNonAcademicPathPercentageAttribute()
    {
        $students = $this->graduatedStudents;
        if ($students->isEmpty()) {
            return 0;
        }

        $nonAcademicCount = 0;
        $totalCount = $students->count();

        foreach ($students as $graduatedStudent) {
            if ($graduatedStudent->student && !$graduatedStudent->student->hasAchievement()) {
                $nonAcademicCount++;
            }
        }

        $percentage = ($nonAcademicCount / $totalCount) * 100;
        return 100 - $percentage;
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function getAverageDistanceAttribute()
    {
        $students = $this->graduatedStudents;
        if ($students->isEmpty() || $this->latitude === null || $this->longitude === null) {
            return null;
        }

        $totalDistance = 0;
        $count = 0;

        foreach ($students as $graduatedStudent) {
            if ($graduatedStudent->student && $graduatedStudent->student->address) {
                $homeLat = $graduatedStudent->student->address->latitude;
                $homeLon = $graduatedStudent->student->address->longitude;

                if ($homeLat !== null && $homeLon !== null) {
                    $distance = $this->calculateDistance($this->latitude, $this->longitude, $homeLat, $homeLon);
                    $totalDistance += $distance;
                    $count++;
                }
            }
        }

        return $count ? $totalDistance / $count : null;
    }

    public function getPerformanceRatings()
    {
        $ratings = [];

        // Assuming we have some predefined criteria weights
        $criteriaWeights = [
            'C1' => 0.45, // Example weight for Average School Score
            'C2' => 0.25, // Example weight for Lowest Accepted Score
            'C3' => 0.15, // Example weight for Academic Path Percentage
            'C4' => 0.1, // Example weight for Non-Academic Path Percentage
            'C5' => 0.05, // Example weight for Average Distance
        ];

        $ratings['C1'] = round($this->average_school_score * $criteriaWeights['C1'], 2);
        $ratings['C2'] = round($this->lowest_accepted_score * $criteriaWeights['C2'], 2);
        $ratings['C3'] = round($this->academic_path_percentage * $criteriaWeights['C3'], 2);
        $ratings['C4'] = round($this->non_academic_path_percentage * $criteriaWeights['C4'], 2);
        $ratings['C5'] = round($this->average_distance * $criteriaWeights['C5'], 2);

        return $ratings;
    }
}
