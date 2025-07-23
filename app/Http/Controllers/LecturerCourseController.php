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

        // Add students_count property to each group (Collection)
        foreach ($groupedEnrollments as $groupCourse => $enrollments) {
            // Only count enrollments that have a student attached
            $groupedEnrollments[$groupCourse]->students_count = $enrollments->filter(function ($enrollment) {
                return $enrollment->student !== null;
            })->count();
        }

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

        // Get groupCourse from the query string (e.g. ?groupCourse=CDCS2402A)
        $groupCourse = $request->query('groupCourse');

        // Get all enrollments for this groupCourse for this lecturer
        $enrollments = CourseEnrollment::where('lecturer_id', $lecturer->id)
            ->where('groupCourse', $groupCourse)
            ->with('student')
            ->get();

        return view('studentList', [
            'enrollments' => $enrollments,
            'groupCourse' => $groupCourse,
        ]);
    }

}

//BEFORE TUKARRRR