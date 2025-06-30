<x-guest-layout>
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
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" id="role" onchange="toggleRoleFields()" required class="block mt-1 w-full">
                <option value="">Select Role</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>
        </div>

        <!-- Student ID -->
        <div id="studentField" style="display: none;" class="mt-4">
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" class="block mt-1 w-full" type="number" name="student_id" />
        </div>

        <!-- Staff ID -->
        <div id="staffField" style="display: none;" class="mt-4">
            <x-input-label for="staff_id" :value="__('Staff ID')" />
            <x-text-input id="staff_id" class="block mt-1 w-full" type="number" name="staff_id" />
        </div>

        <!-- Student: Select Group Course -->
        <div id="groupCourseStudentField" style="display: none;" class="mt-4">
            <x-input-label for="group_course" :value="'Select Group Course (' . $currentSemester . ')'" />
            <select name="group_course" id="group_course" class="block mt-1 w-full">
                @foreach ($groupCourses as $group)
                    <option value="{{ $group }}">{{ $group }}</option>
                @endforeach
            </select>
        </div>

        <!-- Lecturer: Input Group Courses (comma-separated) -->
        <div id="groupCourseLecturerField" style="display: none;" class="mt-4">
            <x-input-label for="group_courses_input" :value="'Enter Group Courses You Manage (comma-separated)'" />
            <x-text-input id="group_courses_input" class="block mt-1 w-full" type="text" name="group_courses_input" />
            <x-input-error :messages="$errors->get('group_courses_input')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            document.getElementById('studentField').style.display = role === 'student' ? 'block' : 'none';
            document.getElementById('staffField').style.display = role === 'lecturer' ? 'block' : 'none';
            document.getElementById('groupCourseStudentField').style.display = role === 'student' ? 'block' : 'none';
            document.getElementById('groupCourseLecturerField').style.display = role === 'lecturer' ? 'block' : 'none';
        }

        window.onload = toggleRoleFields;
    </script>
</x-guest-layout>
