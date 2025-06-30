<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Course;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function editLecturer(Request $request): View
    {
        return view('profile.lecturer-edit-profile', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'room_number' => 'nullable|string|max:255',
        ];

        // Add role-specific validation
        if ($user->role === 'lecturer') {
            $rules['staff_id'] = 'nullable|string|max:255';
        }

        if ($user->role === 'student') {
            $rules['student_id'] = 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

        // Filter based on role
        $updateFields = [
            'name', 'email', 'phone_number', 'position', 'room_number'
        ];

        if ($user->role === 'lecturer') {
            $updateFields[] = 'staff_id';
        }

        if ($user->role === 'student') {
            $updateFields[] = 'student_id';
        }

        $userData = [];
                foreach ($updateFields as $field) {
                    if ($request->has($field)) {
                $userData[$field] = $request->input($field);
                    }
                }
        $user->fill($userData)->save();

                return back()->with('status', 'profile-updated');
            }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

        public function viewLecturerProfile()
        {
            $lecturer = auth()->user();

            // Get the course this lecturer is managing
            $course = $lecturer->course;

            // Group courseEnrollments by groupCourse with student info
            $groupedEnrollments = $course
                ? $course->enrollments()->with('students')->get()->groupBy('groupCourse')
                : collect();

            return view('viewLecturerProfile', compact('lecturer', 'groupedEnrollments', 'course'));
        }


        public function viewStudent(Request $request, $courseId)
        {
            $groupCourse = $request->input('groupCourse');
            
            $course = Course::with(['students' => function ($query) use ($groupCourse) {
                if ($groupCourse) {
                    $query->wherePivot('groupCourse', $groupCourse);
                }
            }])->findOrFail($courseId);

            return view('studentList', compact('course', 'groupCourse'));
        }




}
