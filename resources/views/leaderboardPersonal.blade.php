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
                    class="absolute left-0 mt-1 w-48 bg-white rounded shadow-lg z-30"
                    x-transition>
                    <a href="{{ url('/student/leaderboard/personal') }}"
                    class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-t font-semibold text-sm">
                        Personal Leaderboard
                    </a>
                    <a href="{{ url('/student/leaderboard/overall') }}"
                    class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-b font-semibold text-sm">
                        Overall Leaderboard
                    </a>
                </div>
            </div>
            <!-- Leaderboard Dropdown End -->
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
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
    <main class="ml-64 mt-16 p-8 min-h-screen bg-transparent flex flex-col items-center justify-center">
        <h2 class="text-2xl font-bold text-[#15f7fc] mb-1">PERSONAL LEADERBOARD</h2>
        <div class="w-full max-w-2xl neon-frame p-8 mt-10 mx-auto">
           
            <!-- Centered Profile -->
            <div class="flex flex-col items-center justify-center mb-10">
                <div class="w-28 h-28 rounded-full border-4 border-[#15f7fc] flex items-center justify-center shadow-xl bg-[#061928] mb-3">
                    <img src="{{ asset('asset/A_Fiona.png') }}" alt="avatar" class="w-20 h-20 rounded-full">
                </div>
                <div class="mt-2 flex flex-col items-center">
                    <span class="font-extrabold text-2xl text-white leading-tight">Aina</span>
                    <span class="font-bold text-xl mt-2 text-[#15f7fc] tracking-widest">SCORE : <span class="text-white">94</span></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <!-- Topic 1 -->
                <div class="bg-[#061928dd] border-2 border-[#15f7fc66] rounded-2xl p-5 shadow-lg neon-inner">
                    <h3 class="font-bold text-[#15f7fc] text-lg mb-3 tracking-widest">TOPIC 1</h3>
                    <div class="flex justify-between text-[#b3f3f8] text-base mb-2">
                        <span>Exercise 1:</span> <span>15</span>
                    </div>
                    <div class="flex justify-between text-[#b3f3f8] text-base">
                        <span>Exercise 2:</span> <span>19</span>
                    </div>
                </div>
                <!-- Topic 2 -->
                <div class="bg-[#061928dd] border-2 border-[#15f7fc66] rounded-2xl p-5 shadow-lg neon-inner">
                    <h3 class="font-bold text-[#15f7fc] text-lg mb-3 tracking-widest">TOPIC 2</h3>
                    <div class="flex justify-between text-[#b3f3f8] text-base mb-2">
                        <span>Exercise 1:</span> <span>20</span>
                    </div>
                    <div class="flex justify-between text-[#b3f3f8] text-base">
                        <span>Exercise 2:</span> <span>40</span>
                    </div>
                </div>
                <!-- Topic 3 -->
                <div class="bg-[#061928dd] border-2 border-[#15f7fc66] rounded-2xl p-5 shadow-lg neon-inner">
                    <h3 class="font-bold text-[#15f7fc] text-lg mb-3 tracking-widest">TOPIC 3</h3>
                    <div class="flex justify-between text-[#b3f3f8] text-base mb-2">
                        <span>Exercise 1:</span> <span>20</span>
                    </div>
                    <div class="flex justify-between text-[#b3f3f8] text-base">
                        <span>Exercise 2:</span> <span>40</span>
                    </div>
                     <div class="flex justify-between text-[#b3f3f8] text-base">
                        <span>Exercise 3:</span> <span></span>
                    </div>
                     <div class="flex justify-between text-[#b3f3f8] text-base">
                        <span>Exercise 4:</span> <span></span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
.neon-frame {
    background: rgba(10, 10, 30, 0.95);
    border: 3px solid #15f7fc;
    border-radius: 2px;
    box-shadow:
        0 0 18px 3px #15f7fc,
        0 0 38px 1px #00bfff85 inset,
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
    opacity: 0.4;
    pointer-events: none;
}
.neon-inner {
    box-shadow: 0 0 14px #15f7fc33 inset;
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
</x-app-layout>
