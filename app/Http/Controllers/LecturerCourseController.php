<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollment;

class LecturerCourseController extends Controller
{
public function viewProfile()
{
    $lecturer = auth()->user();

    $courseEnrollments = CourseEnrollment::where('lecturer_id', $lecturer->id)
        ->get();

    // group by groupCourse for the Blade view
    $groupedEnrollments = $courseEnrollments->groupBy('groupCourse');

    return view('viewLecturerProfile', [
        'lecturer' => $lecturer,
        'groupedEnrollments' => $groupedEnrollments
    ]);
}



    public function viewStudent(Request $request, $courseEnrollmentId)
    {
        $lecturer = auth()->user();

        if ($lecturer->role !== 'lecturer') {
            abort(403, 'Unauthorized');
        }

        // Make sure this enrollment belongs to the lecturer
        $courseEnrollment = CourseEnrollment::with('students')
                            ->where('id', $courseEnrollmentId)
                            ->where('lecturer_id', $lecturer->id)
                            ->firstOrFail();

        return view('studentList', [
            'enrollments' => collect([$courseEnrollment]),
            'groupCourse' => $courseEnrollment->groupCourse
        ]);
    }
}
