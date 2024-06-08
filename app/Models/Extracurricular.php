<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_target_id',
        'activity_name',
        'activity_description',
    ];

    /**
     * Get the school target that owns the extracurricular activity.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
