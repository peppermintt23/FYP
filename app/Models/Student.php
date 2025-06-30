<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends User
{
   
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'position',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
  
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
  

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function managedGroupCourses()
    {
        return $this->hasMany(CourseEnrollment::class, 'lecturer_id');
    }
}
