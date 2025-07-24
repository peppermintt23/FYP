<x-app-layout>
<div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
    <!-- Sidebar (Fixed Left) -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50">
        <div class="mb-8 flex items-center space-x-3">
            <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
            <span class="text-2xl font-bold">CQPP</span>
        </div>
        <nav class="space-y-4 mt-8">
            <a href="{{ route('student-dashboard') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
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
            <a href="{{ route('answer.index') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect width="16" height="20" x="4" y="2" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6h6" />
                </svg>
                <span>Exercise</span>
            </a>
            <a href="{{ url('/student/leaderboard/personal') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-7-9a7 7 0 0014 0V4H5v4z" />
                    </svg>
                <span>Personal Leaderboard</span>
            </a>
        </nav>
    </aside>

    <!-- Top Header/Profile Bar (Fixed Top, Full Width) -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
                <span class="font-semibold">{{ Auth::user()->name ?? 'Username' }}</span>
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

    <!-- Main Content -->
    <main class="ml-64 mt-20 p-8 min-h-screen bg-transparent flex flex-col items-center justify-center">
        <div class="w-full max-w-4xl neon-frame p-8 mt-10 mx-auto">
        <h2 class="text-2xl font-bold text-[#15f7fc] mb-6 text-center">
            OVERALL LEADERBOARD<br>
            <span class="text-yellow-300">{{ $exercise->exercise_title ?? '-' }}</span><br>
            <span class="text-[#ffe484]">Group: {{ $myGroup }}</span>
        </h2>

        @if(!$userAnswered)
            <div class="bg-[#061928] neon-frame p-8 mt-10 rounded-lg text-center max-w-md mx-auto">
                <h2 class="text-2xl font-bold text-[#15f7fc] mb-4">Oops!</h2>
                <p class="text-lg text-[#b3f3f8] mb-4">
                    You need to answer this exercise to view the leaderboard.
                </p>
                <a href="{{ route('answer.index') }}"
                   class="neon-btn bg-[#15f7fc] text-white font-semibold rounded px-6 py-2 hover:bg-[#13e2be]">
                    Go to Exercise
                </a>
            </div>
        @else
            {{-- Podium for top 3 --}}
            <div class="flex flex-col md:flex-row justify-center items-end md:space-x-8 space-y-4 md:space-y-0 mb-10">
                @foreach($leaderboard->take(3) as $idx => $entry)
                    @php
                        // Podium heights: Gold = tallest, Silver = shorter, Bronze = shortest
                        $podiumClass = match($idx) {
                            0 => 'z-20', // 1st - center, highest
                            1 => 'z-10 md:order-first', // 2nd - left
                            2 => 'z-10 md:order-last', // 3rd - right
                            default => ''
                        };
                        $podiumStyle = match($idx) {
                            0 => 'pt-14 mb-2',  // Gold
                            1, 2 => 'pt-10 mb-6', // Silver/Bronze
                        };
                        $medal = ['🥇','🥈','🥉'][$idx];
                        $border = match($idx) {
                            0 => '#ffe484', // Gold
                            1 => '#15f7fcbb', // Silver
                            2 => '#15f7fc88', // Bronze
                        };
                    @endphp
                    <div class="w-52 flex flex-col items-center {{ $podiumClass }}">
                        <div class="relative flex flex-col items-center bg-[#061928ee] border-2 border-[{{ $border }}] rounded-2xl p-5 {{ $podiumStyle }} shadow-lg neon-inner">
                            <div class="absolute -top-11">
                                <img src="{{ asset('asset/avatars/' . ($entry->student->avatar ?? 'default-avatar.png')) }}"
                                     class="w-20 h-20 rounded-full border-4 border-[{{ $border }}] shadow-lg"
                                     alt="{{ $entry->student->name }}">
                            </div>
                            <div class="mt-12 text-center">
                                <span class="block font-bold text-lg text-[#15f7fc]">{{ $entry->student->name }}</span>
                                <span class="block text-base text-[#ffe484] font-semibold">
                                    {{ $entry->elapsed_time ? gmdate('i:s', $entry->elapsed_time) : '-' }}
                                </span>
                                <span class="block text-base font-bold text-[#b3f3f8]">POINT : <span class="text-[#15f7fc]">{{ $entry->student_score }}</span></span>
                            </div>
                            <div class="absolute -top-4 right-4">
                                <span style="font-size:2rem;">{{ $medal }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Table for the rest --}}
            @if($leaderboard->count() > 3)
            <div class="rounded-xl overflow-hidden mt-3">
                <table class="min-w-full text-center table-auto">
                    <thead class="bg-[#071c2d]">
                        <tr>
                            <th class="py-3 px-4 text-[#15f7fc] text-base tracking-widest">Rank</th>
                            <th class="py-3 px-4 text-[#15f7fc] text-base tracking-widest">Username</th>
                            <th class="py-3 px-4 text-[#15f7fc] text-base tracking-widest">Time</th>
                            <th class="py-3 px-4 text-[#15f7fc] text-base tracking-widest">Point</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#061928cc]">
                        @foreach($leaderboard->slice(3) as $idx => $entry)
                        <tr class="hover:bg-[#132946bb] transition">
                            <td class="py-3 px-4 text-white font-bold">{{ $idx+4 }}</td>
                            <td class="flex items-center justify-center py-3 px-4 space-x-2">
                                <img src="{{ asset('asset/avatars/' . ($entry->student->avatar ?? 'default-avatar.png')) }}"
                                     class="w-10 h-10 rounded-full border-2 border-[#15f7fc] shadow"
                                     alt="{{ $entry->student->name }}">
                                <span class="text-white font-semibold">{{ $entry->student->name }}</span>
                            </td>
                            <td class="py-3 px-4 text-white font-bold">
                                {{ $entry->elapsed_time ? gmdate('i:s', $entry->elapsed_time) : '-' }}
                            </td>
                            <td class="py-3 px-4 text-[#15f7fc] font-bold">
                                {{ $entry->student_score }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        @endif
        </div>
    </main>
</div>

<style>
.neon-frame {
    background: rgba(10, 18, 36, 0.98);
    border: 3px solid #15f7fc;
    border-radius: 26px;
    box-shadow:
        0 0 18px 3px #15f7fc,
        0 0 38px 1px #15f7fc44 inset,
        0 0 0 7px #061928;
    position: relative;
    overflow: hidden;
}
.neon-frame:before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    border: 2px solid #19ffe7;
    filter: blur(3px);
    opacity: 0.22;
    pointer-events: none;
}
.neon-inner {
    box-shadow: 0 0 16px #15f7fc33 inset;
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
    border-radius: 14px;
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
</x-app-layout>
