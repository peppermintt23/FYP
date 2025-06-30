<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guideline extends Model
{
        protected $fillable = [
            'exercise_id', 
            'step_number',
            'step_description', 
            'expected_code'
        ];

    use HasFactory;
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

}
