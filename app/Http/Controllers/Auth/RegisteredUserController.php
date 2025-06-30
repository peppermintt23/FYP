<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\CourseEnrollment;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $currentSemester = CourseEnrollment::latest('semesterSession')->value('semesterSession');

        $groupCourses = CourseEnrollment::where('semesterSession', $currentSemester)
                            ->select('groupCourse')
                            ->distinct()
                            ->pluck('groupCourse');

        return view('auth.register', compact('groupCourses', 'currentSemester'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'staff_id' => ['required_if:role,lecturer', 'nullable', 'integer', 'unique:users,staff_id'],
            'student_id' => ['required_if:role,student', 'nullable', 'integer', 'unique:users,student_id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,lecturer'],
            'group_courses_input' => ['required_if:role,lecturer'],
        ]);

        $role = $request->role;
        $groupCourses = explode(',', $request->input('group_courses_input'));
        $groupCourses = array_map('trim', $groupCourses);
        $groupCourses = array_filter($groupCourses); // remove empty
        $currentSemester = CourseEnrollment::latest('semesterSession')->value('semesterSession');

        // Check if any groupCourse is already assigned
        if ($role === 'lecturer') {
            $conflicts = [];

            foreach ($groupCourses as $group) {
                $exists = CourseEnrollment::where('groupCourse', $group)
                    ->where('semesterSession', $currentSemester)
                    ->whereNotNull('lecturer_id')
                    ->exists();

                if ($exists) {
                    $conflicts[] = $group;
                }
            }

            if (count($conflicts)) {
                return back()
                    ->withErrors([
                        'group_courses_input' => 'These groupCourses are already managed by other lecturers: ' . implode(', ', $conflicts),
                    ])
                    ->withInput(); // important for old input
            }

        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'staff_id' => $role === 'lecturer' ? $request->staff_id : null,
            'student_id' => $role === 'student' ? $request->student_id : null,
        ]);

        // For lecturer: assign groupCourses
        if ($role === 'student') {
            $selectedGroupCourse = $request->input('group_course');

            $enrollment = CourseEnrollment::where('groupCourse', $selectedGroupCourse)
                ->where('semesterSession', $currentSemester)
                ->first();

            if ($enrollment) {
                $user->course_enrollment_id = $enrollment->id;
               // $user->course_id = $enrollment->course_id;
                $user->save();
            } else {
                // Optional: handle case where groupCourse doesn't exist
                return back()->withErrors([
                    'group_course' => 'The selected group course was not found for the current semester.',
                ])->withInput();
            }
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::redirectToBasedOnRole());
    }

}
