<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Course;
use Illuminate\Support\Arr;  
use App\Models\Topic;

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
            'student_number' => 'nullable|string|max:255,' . $user->id,
            'room_number' => 'nullable|string|max:255',
            'avatar'         => 'nullable|string|max:255',
        ];

        // Add role-specific validation
        if ($user->role === 'lecturer') {
            $rules['staff_number'] = 'nullable|string|max:255';
        }

        if ($user->role === 'student') {
            $rules['student_number'] = 'nullable|string|max:255';
        }

        if (!empty($data['avatar'])) {
            $user->avatar = $rules['avatar'];
        }

        $validated = $request->validate($rules);

        // Filter based on role
        $updateFields = [
            'name', 'email', 'phone_number', 'position', 'room_number', 'avatar'
        ];

        if ($user->role === 'lecturer') {
            $updateFields[] = 'staff_number';
        }

        if ($user->role === 'student') {
            $updateFields[] = 'student_number';
        }

        $userData = [];
                foreach ($updateFields as $field) {
                    if ($request->has($field)) {
                $userData[$field] = $request->input($field);
                    }
                }

         // 2) Save the chosen avatar filename
        if (isset($data['avatar'])) {
            $user->avatar = $userData['avatar'];
        }

        $userData = Arr::only($validated, $updateFields);
        $user->update($userData);

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

            // 1. Find course and eager load students in this groupCourse only
            $course = Course::findOrFail($courseId);

            $students = $course->students()
                ->wherePivot('groupCourse', $groupCourse)
                ->get();

            // 2. If you need to display exercises for this group
            $topics = Topic::where('course_id', $courseId)->get();
            $exercisesByTopic = [];

            foreach ($topics as $topic) {
                $exercises = $topic->exercises()
                    ->where('groupCourse', $groupCourse)
                    ->get();

                $exercisesByTopic[$topic->id] = $exercises;
            }

            // 3. Pass everything to view
            return view('studentList', [
                'course'     => $course,
                'groupCourse'=> $groupCourse,
                'students'   => $students,
                'topics'     => $topics,
                'exercisesByTopic' => $exercisesByTopic,
            ]);
        }



        public function viewStudentProfile(Request $request): View
        {
            // $user is your User model, with role='student'
            $user = $request->user();

            $enrollment = \App\Models\CourseEnrollment::where('student_id', $user->id)->first();
            $groupCourse = $enrollment?->groupCourse ?? null;

            $avatars = [
                'A_BMO.png',
                'A_Cake.png',
                'A_Finn.png',
                'A_Fiona.png',
                'A_Flame_Princess.png',
                'A_Gunter.png',
                'A_Ice_King.png',
                'A_Jake.png',
                'A_lady_Rainicorn.png',
                'A_Lemongrab.png',
                'A_Lumpy_Space_Princess.png',
                'A_Marceline.png',
                'A_Pepperment_Butler.png',
                'A_Slime_Princess.png',
                'A_Tree_Trunks.png',
            ];

            $topics = Topic::with(['exercises' => function($q) use ($groupCourse) {
                $q->where('groupCourse', $groupCourse); // Only this group’s exercises
            }, 'exercises.answers' => function($q) use ($user) {
                $q->where('student_id', $user->id); // Only this student’s answers
            }])
            ->whereHas('exercises', function($q) use ($groupCourse) {
                $q->where('groupCourse', $groupCourse);
            })
            ->get();


            return view('viewStudentProfile', compact('user', 'avatars', 'topics'));
        }

}
