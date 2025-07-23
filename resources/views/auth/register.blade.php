<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    .neon-text {
      color: #15f7fc;
      font-size: 2.5rem;
      font-weight: bold;
      text-shadow:
        0 0 2px #fff,
        0 0 8px #15f7fc,
        0 0 16px #15f7fc,
        0 0 24px #1344ea;
    }
    .neon-input {
      border: 1.5px solid #15f7fc;
      background: #071c2d;
      color: #c9fbff;
      border-radius: 10px;
      padding: 0.7rem 1.2rem;
      outline: none;
      font-size: 1.07rem;
      transition: border 0.2s, box-shadow 0.22s;
      box-shadow: 0 0 8px #1bf7ff25;
    }
    .neon-input:focus {
      border: 2px solid #14e1ee;
      background: #0a132a;
      color: #00fff3;
      box-shadow: 0 0 14px #15f7fc99;
    }
    .neon-btn {
      background: linear-gradient(90deg, #15f7fc 0%, #1344ea 100%);
      color: #071c2d;
      border: none;
      outline: none;
      border-radius: 8px;
      font-weight: bold;
      letter-spacing: 1px;
      transition: box-shadow 0.22s, background 0.22s;
      box-shadow: 0 0 12px #15f7fc99, 0 0 24px #15f7fc33 inset;
    }
    .neon-btn:hover {
      filter: brightness(1.13) saturate(1.5);
      box-shadow: 0 0 20px #15f7fcdd;
      background: linear-gradient(90deg, #1344ea 0%, #15f7fc 100%);
      color: #fff;
    }
    .neon-checkbox {
      accent-color: #15f7fc;
      width: 18px;
      height: 18px;
      border-radius: 6px;
      border: 2px solid #15f7fc;
      background: #0a192f;
      box-shadow: 0 0 6px #15f7fc88;
      transition: box-shadow 0.2s;
    }
    .neon-checkbox:checked {
      box-shadow: 0 0 14px #15f7fc99;
    }
  </style>
</head>
<body
  class="min-h-screen flex items-center justify-center"
  style="background: url('{{ asset('asset/bg.png') }}') center/cover no-repeat; background-size: cover; image-rendering: auto;"
>
  <div class="w-full max-w-md px-4">
    <!-- Neon Title -->
    <h2 class="neon-text text-center mb-6">SIGNUP</h2>

    <!-- Semi-transparent panel -->
    <div class="p-8 rounded-lg" style="background-color: rgba(10, 25, 40, 0.4);">
      {{-- Validation Errors --}}
      @if ($errors->any())
        <div class="mb-4 text-red-600">
          <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
          <x-input-label class="text-white" for="name" :value="__('Name')" />
          <x-text-input id="name" class="neon-input block mt-1 w-full"
                        type="text" name="name" required autofocus autocomplete="name" />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
          <x-input-label class="text-white" for="role" :value="__('Role')" />
          <select name="role" id="role" onchange="toggleRoleFields()" required
                  class="neon-input block mt-1 w-full">
            <option value="">Select Role</option>
            <option value="student"  {{ old('role')=='student'  ? 'selected':'' }}>Student</option>
            <option value="lecturer" {{ old('role')=='lecturer' ? 'selected':'' }}>Lecturer</option>
          </select>
        </div>

        <!-- Student-only -->
        <div id="studentSection" style="display:none;">
          <div class="mt-4">
            <x-input-label class="text-white" for="student_id" :value="__('Student Number')" />
            <x-text-input id="student_id" class="neon-input block mt-1 w-full"
                          type="number" name="student_id" :value="old('student_id')" />
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
          </div>
          <input type="hidden" name="semesterSession" value="{{ $currentSemester }}">
          <div class="mt-4">
            <x-input-label class="text-white" for="programmeCode" :value="__('Programme Code')" />
            <select name="programmeCode" id="programmeCode" class="neon-input block mt-1 w-full">
              @foreach($programmeCodes as $code)
                <option value="{{ $code }}" {{ old('programmeCode')==$code?'selected':'' }}>
                  {{ $code }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="mt-4">
            <x-input-label class="text-white" for="course_id" :value="__('Course')" />
            <select name="course_id" id="course_id" class="neon-input block mt-1 w-full">
              @foreach($courses as $c)
                <option value="{{ $c->id }}" {{ old('course_id')==$c->id?'selected':'' }}>
                  {{ $c->courseCode }} — {{ $c->courseName }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="mt-4">
            <x-input-label class="text-white" for="groupCourse"
                           :value="__('Group Course (' . $currentSemester . ')')" />
            <select name="groupCourse" id="groupCourse" class="neon-input block mt-1 w-full">
              @foreach($groupCourses as $group)
                <option value="{{ $group }}" {{ old('groupCourse')==$group?'selected':'' }}>
                  {{ $group }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Lecturer-only -->
        <div id="lecturerSection" style="display:none;">
          <div class="mt-4">
            <x-input-label class="text-white" for="staff_id" :value="__('Staff Number')" />
            <x-text-input id="staff_id" class="neon-input block mt-1 w-full"
                          type="number" name="staff_id" :value="old('staff_id')" />
            <x-input-error :messages="$errors->get('staff_id')" class="mt-2" />
          </div>
          <div class="mt-4">
            <x-input-label class="text-white" for="group_courses_input"
                           :value="__('Enter Group Courses (comma-separated)')" />
            <x-text-input id="group_courses_input"
                          class="neon-input block mt-1 w-full"
                          type="text"
                          name="group_courses_input"
                          :value="old('group_courses_input')" />
            <x-input-error :messages="$errors->get('group_courses_input')" class="mt-2" />
          </div>
        </div>

        <!-- Email -->
        <div class="mt-6">
          <x-input-label class="text-white" for="email" :value="__('Email')" />
          <x-text-input id="email" class="neon-input block mt-1 w-full"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
          <x-input-label class="text-white" for="password" :value="__('Password')" />
          <x-text-input id="password" class="neon-input block mt-1 w-full"
                        type="password" name="password" required autocomplete="new-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
          <x-input-label class="text-white"
                         for="password_confirmation"
                         :value="__('Confirm Password')" />
          <x-text-input id="password_confirmation"
                        class="neon-input block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required autocomplete="new-password" />
          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-6">
          <a class="underline text-sm text-gray-200 hover:text-white"
             href="{{ route('login') }}">
            {{ __('Already have an account?') }}
          </a>
          <button type="submit" class="neon-btn ml-4 px-6 py-2">
            {{ __('Sign Up') }}
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleRoleFields() {
      const role = document.getElementById('role').value;
      document.getElementById('studentSection').style.display  = role === 'student'  ? 'block' : 'none';
      document.getElementById('lecturerSection').style.display = role === 'lecturer' ? 'block' : 'none';
    }
    window.addEventListener('DOMContentLoaded', toggleRoleFields);
  </script>
</body>
</html>
