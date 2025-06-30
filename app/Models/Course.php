<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function lecturer()
    {
        return $this->hasMany(User::class, 'course_id')->where('role', 'lecturer');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollment', 'course_id', 'student_id')
                    ->withPivot('groupCourse', 'programmeCode', 'semesterSession') 
                    ->where('role', 'student');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'course_id');
    }

}
