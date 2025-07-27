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
use App\Models\User;
use App\Models\Answer;
use App\Models\CourseEnrollment;

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
            'phone_number' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current-password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }

        public function viewLecturerProfile()
        {
            $lecturer = auth()->user();

            // Get all unique groupCourse(s) this lecturer manages
            $classes = CourseEnrollment::where('lecturer_id', $lecturer->id)
                        ->select('groupCourse')
                        ->distinct()
                        ->get();

            return view('viewLecturerProfile', compact('lecturer', 'classes'));
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

        public function leaderboardLecturer(Request $request, $groupCourse)
        {
            $topics = \App\Models\Topic::with('exercises')->orderBy('id')->get();
            $enrollments = \App\Models\CourseEnrollment::with('student')
                ->where('groupCourse', $groupCourse)
                ->get();

            $classes = \App\Models\CourseEnrollment::where('lecturer_id', auth()->id())
                ->select('groupCourse')->groupBy('groupCourse')->get();

            $studentIds = $enrollments->pluck('student_id')->all();

            // Key answers as [student_id][exercise_id]
            $answers = \App\Models\Answer::whereIn('student_id', $studentIds)
                ->get()
                ->groupBy(['student_id', 'exercise_id']);

            $students = [];
            foreach ($enrollments as $enroll) {
                $student = $enroll->student;
                if (!$student) continue;

                $totalPoints = 0;
                $minTime = null;
                $topicScores = []; // For per-topic breakdown

                foreach ($topics as $topic) {
                    $topicTotal = 0;
                    $answered = false;

                    foreach ($topic->exercises as $exercise) {
                        $ans = $answers[$student->id][$exercise->id][0] ?? null;
                        if ($ans) {
                            $topicTotal += (int)$ans->student_score;
                            $totalPoints += (int)$ans->student_score;
                            $answered = true;
                            if (!is_null($ans->elapsed_time)) {
                                if (is_null($minTime) || $ans->elapsed_time < $minTime) {
                                    $minTime = $ans->elapsed_time;
                                }
                            }
                        }
                    }

                    // If student answered at least one exercise, show score, else dash
                    $topicScores[$topic->id] = $answered ? $topicTotal : null;
                }

                $students[] = [
                    'id' => $student->id,
                    'name' => $student->name,
                    'avatar' => $student->avatar ? asset('asset/avatars/' . $student->avatar) : asset('asset/avatars/default-avatar.png'),
                    'time' => $minTime !== null ? gmdate("H:i:s", $minTime) : '-',
                    'totalPoints' => $totalPoints,
                    'topicScores' => $topicScores, // add per-topic scores
                ];
            }

            // Sort: points desc, time asc
            usort($students, function ($a, $b) {
                if ($b['totalPoints'] == $a['totalPoints']) {
                    return strcmp($a['time'], $b['time']);
                }
                return $b['totalPoints'] <=> $a['totalPoints'];
            });
            foreach ($students as $i => &$s) $s['rank'] = $i + 1;

            if ($request->expectsJson() || $request->query('json')) {
                return response()->json([
                    'students' => $students,
                    'topics' => $topics,
                ]);
            }

            return view('leaderboardLecturer', [
                'groupCourse' => $groupCourse,
                'students' => $students,
                'topics' => $topics,
                'classes' => $classes,
            ]);
        }






        public function viewStudentProfile(Request $request): View
        {
            // $user is your User model, with role='student'
            $user = $request->user();

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
                'A_Slime_Princess.png',
                'A_Tree_Trunks.png',
            ];

             $topics = Topic::with(['exercises.answers' => function($q) use ($user) {
                $q->where('student_id', $user->id);
            }])->get();

            return view('viewStudentProfile', compact('user', 'avatars', 'topics'));
        }

}
