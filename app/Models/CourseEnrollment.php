<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $table = 'course_enrollment';

    protected $fillable = [
        'semesterSession',
        'programmeCode',
        'groupCourse',
        'course_id',
        'student_id',
        'lecturer_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id')
                    ->where('role', 'student');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id', 'id')
                    ->where('role', 'lecturer');
    }
}
