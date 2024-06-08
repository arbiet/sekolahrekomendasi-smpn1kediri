<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFinalScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'mathematics',
        'science',
        'english',
        'indonesian',
        'civics',
        'religion',
        'physical_education',
        'arts_and_crafts',
        'local_content',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
