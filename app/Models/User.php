<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'staff_number',
        'student_number',
        'password',
        'role',
        'position',
        'username',
        'room_number',
        'avatar',  
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeLecturer($query)
    {
        return $query->where('role', 'lecturer');
    }

    // public function courseEnrollments()
    // {
    //     return $this->hasOne(CourseEnrollment::class);
    // }

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'student_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id')
            ->where('role', 'student');
    }


    public function managedGroupCourses()
    {
        return $this->hasMany(CourseEnrollment::class, 'lecturer_id');
    }
}
