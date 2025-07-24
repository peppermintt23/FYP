<x-app-layout>
    <div class="flex min-h-screen w-full bg-[#050e1a]">
        <!-- Top Header -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-cyan-200 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-[#0f172a] border border-cyan-400 rounded shadow-md divide-y divide-gray-200 z-50">
                    <div class="py-1">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-cyan-200 hover:bg-cyan-900 hover:text-white">
                            Profile
                        </a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-cyan-200 hover:bg-cyan-900 hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 neon-sidebar">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-12 h-12">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="dashboard" class="flex items-center space-x-3 sidebar-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manage.notes') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Manage Learning Material</span>
                </a>
                <a href="{{ route('exercises.manage', $topic->id ?? 1) }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Manage Exercise</span>
                </a>
                <a href="{{ route('leaderboard.lecturer') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Leaderboard</span>
                </a>
                <a href="report" class="flex items-center space-x-3 sidebar-link">
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
       <main class="ml-64 pt-24 min-h-screen flex flex-col">
            <div class="w-full max-w-3xl neon-frame p-4 ml-0">
                @if(session('error'))
                    <div class="mb-4 p-3 rounded bg-red-600 text-white text-center font-semibold shadow">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-4 p-3 rounded bg-green-600 text-white text-center font-semibold shadow">
                        {{ session('success') }}
                    </div>
                @endif

                @php
                    $courses = App\Models\Course::all();
                @endphp

                <!-- Add Topic Form -->
                <h2 class="text-3xl font-bold mb-6 text-cyan-300">Manage Topics & Exercises</h2>
                <form method="GET" action="" class="flex items-center space-x-4 mb-6">
                    <select name="course_id" class="neon-input flex-1">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->courseCode }} - {{ $course->courseName }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="neon-btn bg-[#7d5fff]">Filter</button>
                </form>

                <!-- Topics List -->
                @foreach ($topics as $topic)
                    <fieldset class="border border-cyan-400 p-6 bg-[#101b2a] rounded-2xl shadow-sm mb-8">
                        <div class="">
                            <div class="flex justify-between items-start pb-4">
                                <h3 class="text-xl font-bold text-cyan-100">{{ $topic->topic_title }}</h3>
                                <form action="{{ route('topics.destroy', $topic->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this topic?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="neon-btn bg-gradient-to-r from-pink-500 to-red-600 hover:from-red-500 hover:to-pink-500">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <a href="{{ route('exercises.create', $topic->id) }}"
                                class="neon-btn bg-[#040720] mb-4">
                                Add Exercise
                            </a>
                            <fieldset class="border border-cyan-700 p-6 bg-[#17223a]s shadow-sm mb-6">
                                <ul class="space-y-6">
                                    @foreach ($topic->exercises as $exercise)
                                        <li class="grid md:grid-cols-2 gap-4 pb-6 items-start">
                                            <div class="flex flex-col gap-2">
                                                <p class="text-lg font-semibold text-cyan-200">
                                                    Exercise {{ $loop->iteration }}: {{ $exercise->exercise_title }}
                                                </p>
                                                <span class="flex space-x-3 mt-2">
                                                    <a href="{{ route('exercises.edit', $exercise->id) }}"
                                                        class="neon-btn bg-gradient-to-r from-[#599ebd] to-[#42caff]">
                                                        Update
                                                    </a>
                                                    <form action="{{ route('exercises.destroy', $exercise->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this exercise?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="neon-btn bg-gradient-to-r from-pink-500 to-red-600">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </span>
                                            </div>
                                              <div class="w-full md:w-72 border border-cyan-700 p-6 bg-[#0d1626] rounded-xl shadow-sm self-stretch flex flex-col justify-center">
                                                <h4 class="text-md font-bold mb-2 text-cyan-300">Student answer by group:</h4>
                                                <div class="grid grid-cols-1 gap-2">
                                                    @php
                                                        $lecturerId = Auth::id(); // or Auth::user()->id
                                                        $classes = \App\Models\CourseEnrollment::with('course')
                                                            ->where('lecturer_id', $lecturerId)
                                                            ->select('course_id', 'groupCourse', 'semesterSession')
                                                            ->groupBy('course_id', 'groupCourse', 'semesterSession')
                                                            ->get();

                                                    @endphp
                                                    @foreach ($classes as $class)
                                                        <a href="{{ route('studentAnswer', ['exerciseId' => $exercise->id, 'groupId' => $class->groupCourse]) }}"
                                                            class="inline-block bg-cyan-200 text-[#093c44] text-sm font-medium px-3 py-1 rounded-full hover:bg-cyan-400 transition">
                                                            {{ $class->groupCourse }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </fieldset>
                        </div>
                    </fieldset>
                @endforeach
                
            </div>
        </main>
    </div>

    <style>
    html, body {
        background: #050e1a !important;
        min-height: 100vh;
        width: 100vw;
    }

    .neon-sidebar {
        background: #0a132a;
        border-right: 3.5px solid #13e2be;
        box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
    }

    .sidebar-link {
        background: transparent;
        border: 2px solid transparent;
        border-radius: 2px;
        color: #c9fbff;
        font-weight: 500;
        transition: all 0.18s;
        letter-spacing: 1.2px;
        padding: 0.75rem 1.2rem;
        display: flex;
        align-items: center;
    }
    .sidebar-link:hover, .sidebar-link.active {
        background: #142755bb;
        border-color: #15f7fc;
        color: #15f7fc;
        box-shadow: 0 0 10px #15f7fc44;
    }
    .neon-frame {
        background: rgba(10, 10, 30, 0.90);
        border: 3px solid #15f7fc;
        border-radius: 2px;
        box-shadow: 0 0 22px 3px #15f7fc, 0 0 38px 1px #00bfff85 inset, 0 0 0 7px #061928;
        position: relative;
        overflow: hidden;
    }
    .neon-input {
        border: 1.5px solid #15f7fc;
        background: #071c2d;
        color: #c9fbff;
        border-radius: 2px;
        padding: 0.5rem 1rem;
        outline: none;
        transition: border 0.2s;
    }
    .neon-input:focus {
        border: 2px solid #14e1ee;
        background: #0a132a;
        color: #00fff3;
        box-shadow: 0 0 12px #19ffe799;
    }
    .neon-btn {
        border: none;
        outline: none;
        color: #fff;
        font-weight: bold;
        border-radius: 2px;
        padding: 0.5rem 1.5rem;
        box-shadow: 0 0 8px #14e1ee44;
        transition: background 0.22s, box-shadow 0.22s, color 0.16s;
        letter-spacing: 1px;
        cursor: pointer;
    }
    .neon-btn:hover {
        filter: brightness(1.13) saturate(1.5);
        box-shadow: 0 0 18px #15f7fc77;
    }
    </style>
</x-app-layout>
