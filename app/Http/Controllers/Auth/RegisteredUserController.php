<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // 1. get the current semester
        $currentSemester = CourseEnrollment::latest('semesterSession')
                                ->value('semesterSession');

        // 2. pull distinct groupCourses & programmeCodes
        $groupCourses   = CourseEnrollment::where('semesterSession', $currentSemester)
                               ->distinct()
                               ->pluck('groupCourse');

        $programmeCodes = CourseEnrollment::where('semesterSession', $currentSemester)
                               ->distinct()
                               ->pluck('programmeCode');

        // 3. load all courses
        $courses = Course::all();

        // 4. pass them all to the view
        return view('auth.register', compact(
            'groupCourses',
            'programmeCodes',
            'courses',
            'currentSemester'
        ));
    }

    public function store(Request $request): RedirectResponse
{
    // … your existing validation & user-creation …

    // Create the user
    $user = User::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'role'       => $request->role,
        'student_id' => $request->role === 'student'
                            ? $request->student_id 
                            : null,
        'staff_id'   => $request->role === 'lecturer'
                            ? $request->staff_id 
                            : null,
    ]);

    // grab current semester
    $currentSemester = CourseEnrollment::latest('semesterSession')
                            ->value('semesterSession');

    if ($request->role === 'student') {
        // optionally find the lecturer for this group (if one exists)
        $lecturerId = CourseEnrollment::where([
                ['semesterSession', $currentSemester],
                ['programmeCode',   $request->programmeCode],
                ['groupCourse',     $request->groupCourse],
            ])
            ->value('lecturer_id');

        // now just create a brand-new enrollment row
        CourseEnrollment::create([
            'semesterSession' => $currentSemester,
            'programmeCode'   => $request->programmeCode,
            'course_id'       => $request->course_id,
            'groupCourse'     => $request->groupCourse,
            'student_id'      => $user->id,
            'lecturer_id'     => $lecturerId,           // or null if none
        ]);
    }

    if ($request->role === 'lecturer') {
        $groups = array_filter(array_map('trim',
            explode(',', $request->group_courses_input)
        ));

        foreach ($groups as $grp) {
            CourseEnrollment::where('semesterSession', $currentSemester)
                ->where('groupCourse', $grp)
                ->update(['lecturer_id' => $user->id]);
        }
    }

    event(new Registered($user));
    Auth::login($user);

    return redirect()->intended(RouteServiceProvider::redirectToBasedOnRole());
}

}
