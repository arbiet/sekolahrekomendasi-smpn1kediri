<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_target_id',
        'passing_rate',
        'average_score',
    ];

    /**
     * Get the school target that owns the academic record.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
