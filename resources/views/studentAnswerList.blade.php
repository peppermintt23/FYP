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
                        <a href="{{ url('/lecturer/profile/') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                
                <a href="{{ route('viewReport') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="pl-80 pt-20 min-h-screen flex flex-col items-start bg-transparent">
            <div class="w-full max-w-3xl mx-auto p-8 neon-frame relative mt-6">
                <!-- Close Button -->
                <a href="{{ route('exercises.manage') }}"
                    class="absolute top-4 right-4 text-[#15f7fc] bg-[#132946] border border-[#15f7fc66] hover:bg-[#15f7fc] hover:text-[#071c2d] px-4 py-2 rounded-xl shadow transition duration-150 z-50 font-bold text-xl neon-label">
                    &times;
                </a>
                <h2 class="text-2xl font-extrabold mb-7 text-[#15f7fc] tracking-wide drop-shadow-neon">{{ $groupId }} - {{ $exercise->exercise_title }}</h2>
                <div class="overflow-x-auto rounded-xl border border-[#13e2be66] bg-[#061928f7] neon-inner">
                    <table class="min-w-full text-base">
                        <thead>
                            <tr class="bg-[#071c2d] text-[#15f7fc] font-bold text-base">
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Student Name</th>
                                <th class="px-4 py-3 text-left">Score</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Student Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($answers as $answer)
                                <tr class="border-b border-[#13e2be22] hover:bg-[#142755bb] transition">
                                    <td class="px-4 py-3 text-white">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 font-medium text-[#15f7fc]">{{ $answer->student->name }}</td>
                                    <td class="px-4 py-3 text-[#15f7fc]">{{ $answer->student_score ?? 0 }}</td>
                                    <td class="px-4 py-3 text-white">{{ $answer->status }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('answer.show', [
                                            'exercise' => $answer->exercise,
                                            'student_id' => $answer->student->id
                                        ]) }}"
                                           class="view-answer-btn">
                                            View Answer
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        /* Table */
        table th, table td {
            transition: background 0.2s, color 0.2s;
        }
        .view-answer-btn {
            background: linear-gradient(90deg, #15f7fc 60%, #13e2be 100%);
            color: #09304d;
            padding: 7px 19px;
            border-radius: 7px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            box-shadow: 0 0 7px #12e0be66;
            cursor: pointer;
            transition: 0.18s;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        .view-answer-btn:hover {
            color: #fff;
            background: linear-gradient(90deg, #13e2be 40%, #15f7fc 100%);
            box-shadow: 0 0 18px #13e2be99;
        }

        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
            background: #101b2a;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #15f7fc44;
            border-radius: 4px;
        }

        /* Responsive fixes */
        @media (max-width: 900px) {
            main.pl-72 { padding-left: 0 !important; }
            aside { display: none; }
        }
    </style>
</x-app-layout>

