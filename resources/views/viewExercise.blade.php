<x-app-layout>
    <div class="min-h-screen w-full bg-[#050e1a] text-gray-900">

        <!-- Sidebar (Neon) -->
        <aside class="fixed left-0 top-0 h-screen w-64 text-white p-6 z-50">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="dashboard" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 4l9 5.75M4.5 10.5V19a1.5 1.5 0 001.5 1.5h12a1.5 1.5 0 001.5-1.5v-8.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('notes.index') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="4" width="7" height="16" rx="2" ry="2" stroke-width="2" stroke="currentColor" fill="none"/>
                        <rect x="14" y="4" width="7" height="16" rx="2" ry="2" stroke-width="2" stroke="currentColor" fill="none"/>
                    </svg>
                    <span>Notes</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="16" height="20" x="4" y="2" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6h6" />
                    </svg>
                    <span>Exercise</span>
                </a>
                <!-- Leaderboard Dropdown Start -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button"
                        class="flex items-center w-full space-x-3 hover:bg-[#142755bb] p-2 rounded focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-7-9a7 7 0 0014 0V4H5v4z" />
                        </svg>
                        <span>Leaderboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute left-0 mt-1 w-48 bg-gray rounded shadow-lg z-30"
                        x-transition>
                        <a href="{{ url('/student/leaderboard/personal') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-t">
                            Personal Leaderboard
                        </a>
                        <a href="{{ url('/student/leaderboard/overall') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-b">
                            Overall Leaderboard
                        </a>
                    </div>

                </div>
                <!-- Leaderboard Dropdown End -->
            </nav>
        </aside>

        <!-- Top Header/Profile Bar (Neon) -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200 z-50">
                    <div class="py-1">
                        <a href="{{ url('/student/profile/') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content (Neon Frame) -->
        <main class="ml-64 mt-20 p-8 min-h-screen bg-transparent flex flex-col items-start justify-center">
            <h2 class="text-3xl text-white font-extrabold mb-8">Exercise</h2>
            <div class="w-full overflow-x-auto">
                <div class="flex gap-10 pb-12 min-w-[850px]">
                    @foreach ($topics as $topic)
                        <div class="flex flex-col items-center">
                            <!-- Neon Large Card -->
                            <div class="neon-card w-[340px] h-[430px] flex flex-col justify-between px-6 py-7 mb-4 shadow-2xl">
                                <div>
                                    <h3 class="text-2xl font-bold mb-4 text-[#15f7fc]">{{ $topic->topic_title }}</h3>
                                    <div class="overflow-y-auto max-h-[280px] pr-1 custom-scroll">
                                        @foreach ($topic->exercises as $exercise)
                                            @php $answer = optional($exercise->answers)->first(); @endphp
                                            <div class="bg-[#071c2d] text-white mb-3 rounded-lg px-3 py-2 border border-[#15f7fc44]">
                                                <div class="font-semibold text-[#15f7fc]">{{ $exercise->exercise_title }}</div>
                                                <div class="text-sm mt-1">Status:
                                                    <span class="font-bold text-[#13e2be]">
                                                        {{ $answer?->status ?? 'Not Started' }}
                                                    </span>
                                                </div>
                                                <a href="{{ route('answer.show', [$exercise->id, auth()->id()]) }}"
                                                    class="inline-block mt-2 px-3 py-1 rounded bg-[#13e2be] text-[#071c2d] font-bold shadow hover:bg-[#15f7fc] hover:text-black transition">
                                                    Answer
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Neon Small Box for Topic Name -->
                            <div class="neon-label px-7 py-3 text-lg font-bold text-[#15f7fc] text-center shadow">
                                {{ 'Topic ' . $loop->iteration }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

    </div>

    <style>
    .neon-card {
        background: rgba(8, 15, 35, 0.92);
        border: 3px solid #15f7fc;
        border-radius: 20px;
        box-shadow:
            0 0 24px 0 #15f7fc99,
            0 0 60px 2px #13bcff66 inset;
        position: relative;
        transition: box-shadow 0.2s, border 0.2s;
    }
    .neon-card:hover {
        box-shadow:
            0 0 34px 4px #00ffffaa,
            0 0 80px 4px #15f7fc55 inset;
        border-color: #13e2be;
    }

    .neon-label {
        background: rgba(8, 15, 35, 0.97);
        border: 3px solid #15f7fc;
        border-radius: 12px;
        box-shadow:
            0 0 12px #15f7fc88,
            0 0 28px #15f7fc44 inset;
        letter-spacing: 1.5px;
    }
    .custom-scroll::-webkit-scrollbar {
        width: 8px;
        background: transparent;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #13e2be44;
        border-radius: 6px;
    }


    .neon-frame {
        background: rgba(10, 10, 30, 0.90);
        border: 3px solid #15f7fc;
        border-radius: 24px;
        box-shadow:
            0 0 18px 3px #15f7fc,
            0 0 38px 1px #00bfff85 inset,
            0 0 0 7px #061928;
        position: relative;
        overflow: hidden;
    }
    .neon-frame:before,
    .neon-frame:after {
        content: '';
        position: absolute;
        pointer-events: none;
        border-radius: inherit;
    }
    .neon-frame:before {
        inset: 0;
        border: 2px solid #19ffe7;
        filter: blur(3px);
        opacity: 0.55;
    }
    .neon-frame:after {
        inset: 8px;
        border: 2px solid #19ffe75c;
        filter: blur(7px);
        opacity: 0.3;
    }
    .neon-frame h2,
    .neon-frame h3,
    .neon-frame span,
    .neon-frame .text-white {
        color: #15f7fc !important;
        text-shadow: 0 0 12px #15f7fc99, 0 2px 14px #00284999;
        letter-spacing: 1.5px;
    }
    aside.fixed {
        background: linear-gradient(160deg, #0a132a 70%, #14e1ee3c 100%);
        border-right: 3.5px solid #13e2be;
        box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
    }
    aside.fixed .text-2xl {
        color: #13e2be !important;
        text-shadow: 0 0 8px #13e2be77;
    }
    aside.fixed nav a {
        background: transparent;
        border: 2px solid transparent;
        border-radius: 2px;
        color: #c9fbff;
        font-weight: 500;
        transition: all 0.18s;
        letter-spacing: 1.2px;
    }
    aside.fixed nav a:hover,
    aside.fixed nav a.active {
        background: #142755bb;
        border-color: #15f7fc;
        color: #15f7fc;
        box-shadow: 0 0 10px #15f7fc44;
    }
    header.fixed {
        background: #071c2d;
        box-shadow: 0 1px 10px #14e1ee33;
        color: #13e2be;
    }
    header .font-semibold {
        color: #15f7fc;
        text-shadow: 0 0 6px #15f7fcaa;
    }
    body, .min-h-screen {
        background: #050e1a;
    }
    </style>
    <script>
        function toggleExercises(topic_id) {
            const div = document.getElementById('exercises-' + topic_id);
            div.style.display = div.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</x-app-layout>
