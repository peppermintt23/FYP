<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\NewUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CppCompilerController;
use App\Http\Controllers\LecturerCourseController;
use App\Models\CourseEnrollment;


Route::get('/', function () {
    return view('auth.login');
});

// Registration
Route::get('register', [RegisteredUserController::class, 'showRegistrationForm']);
Route::post('register', [RegisteredUserController::class, 'register']);

// Dashboard (Single definition)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'prevent-back-button'])
    ->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lecturer/profile/edit', [ProfileController::class, 'editLecturer'])->name('lecturer.profile.edit');

    Route::get('/lecturer/view-profile', [ProfileController::class, 'viewLecturerProfile'])->name('lecturer.profile.view');
});

// Custom user and password routes
Route::get('/new-user', [NewUserController::class, 'showForm'])->name('new-user.form');
Route::post('/new-user', [NewUserController::class, 'sendTemporaryPassword'])->name('new-user.send');

Route::get('/change-password', [PasswordChangeController::class, 'showForm'])->name('password.change.form');
Route::post('/change-password', [PasswordChangeController::class, 'change'])->name('password.change');

// Group routes for authenticated users
Route::middleware(['auth'])->group(function () {

    // -------------------------------
    // Student Routes
    // -------------------------------
    Route::get('/student/dashboard', function () {
        return view('student-dashboard');
    })->name('student-dashboard');

    // View and download notes
    Route::get('/student/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/student/notes/download/{id}', [NoteController::class, 'download'])->name('notes.download');

    // Student exercises
    Route::get('/student/exercises', [AnswerController::class, 'index'])->name('answer.index');
    Route::get('/student/exercises/{exercise}', [AnswerController::class, 'show'])->name('answer.show');
    Route::get('/student/exercises/feedback/{exercise}', [AnswerController::class, 'feedback'])->name('answer.feedback');
    Route::get('/student/exercises/compilerAswer/{exercise}', [AnswerController::class, 'compilerAswer'])->name('answer.compilerAswer');
    Route::post('/student/exercises/{exercise}/submit', action: [AnswerController::class, 'submitExercise'])->name('answer.submitExercise');
    Route::post('/student/exercises/{exercise}/submitFinalExercise', action: [AnswerController::class, 'submitFinalExercise'])->name('answer.submitFinalExercise');


    // C++ Compiler route (API to Judge0)
    Route::post('/run-cpp', [CppCompilerController::class, 'runCpp'])->name('cpp.run');

    // -------------------------------
    // Lecturer Routes
    // -------------------------------
    Route::get('/lecturer/dashboard', [DashboardController::class, 'index'])
        ->name('lecturer.dashboard');


    Route::get('/lecturer/manage-notes', [TopicController::class, 'manageNotes'])->name('manage.notes');

    // Topics
    Route::get('/lecturer/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::post('/lecturer/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::delete('/lecturer/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');

    //Student Answers
    Route::get('/lecturer/studentAnswer/{exerciseId}/{groupId}', [AnswerController::class, 'studentAnswer'])
        ->name('studentAnswer');

    // Notes
    Route::post('/lecturer/topics/{topic}/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/lecturer/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // Exercises
    Route::get('/manage-exercise', [ExerciseController::class, 'manageExercise'])->name('exercises.manage');
    Route::get('/lecturer/exercises/manage', [ExerciseController::class, 'manageExercise']);

    Route::get('/lecturer/exercises/create/{topic}', [ExerciseController::class, 'create'])->name('exercises.create');
    Route::post('/lecturer/exercises/store/{topic}', [ExerciseController::class, 'store'])->name('exercises.store');

    Route::get('/lecturer/exercises/edit/{exercise}', [ExerciseController::class, 'edit'])->name('exercises.edit');
    Route::put('/lecturer/exercises/update/{exercise}', [ExerciseController::class, 'update'])->name('exercises.update');
    Route::delete('/lecturer/exercises/manage/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');

    // Guidelines
    Route::post('/lecturer/exercises/{exercise}/create_guideline', [ExerciseController::class, 'create_guideline'])->name('exercises.create_guideline');
    Route::put('/lecturer/exercises/{exercise}/guideline/{guideline}', [ExerciseController::class, 'update_guideline'])->name('exercises.update_guideline');
    Route::delete('/lecturer/exercises/{exercise}/guideline/{guideline}', [ExerciseController::class, 'destroy_guideline'])->name('exercises.destroy_guideline');

    // View student answers
    Route::get('/lecturer/exercises/{exercise}/answers', [ExerciseController::class, 'answers'])->name('exercises.answers');

    Route::get('/lecturer/profile', [LecturerCourseController::class, 'viewProfile'])->name('lecturer.profile.view');
    Route::get('/lecturer/profile/students/{courseEnrollmentId}', [LecturerCourseController::class, 'viewStudent'])->name('lecturer.course.students');
});

// Auth routes
require __DIR__ . '/auth.php';
