<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

      protected $fillable = [
        'exercise_title', 
        'question', 
        'hint', 
        'expected_output', 
        'score', 
        'has_guideline',  // Make sure this is here
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function guidelines()
    {
        return $this->hasMany(Guideline::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(Answer::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class,'exercise_id');
    }

} 