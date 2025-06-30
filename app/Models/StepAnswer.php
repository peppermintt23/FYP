<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'student_id',
        'step_number',
        'answer',
    ];

    // Define relationships
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

