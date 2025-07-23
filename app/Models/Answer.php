<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    const PENDING_STATUS = 'Pending';//baru create draft data dahjawab
    const STATUS_1 = 'Completed Guideline';//submittedGuideline
    const STATUS_2 = 'Completed - Pending Feedback';//submittedcode
    const STATUS_3 = 'Completed - Submitted Feedback';

    use HasFactory;
    protected $fillable = [
        'student_id', 
        'exercise_id', 
        'step_number', 
        'answer',
        'category',  
        'student_score',
        'parent_answer_id',
        'feedback',
        'status'
    ];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exercise() {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

}
