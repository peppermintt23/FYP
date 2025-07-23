@php
    use App\Models\Answer;
@endphp
<x-app-layout>
    <div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
        <!-- Sidebar (Fixed Left) -->
        <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 ">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="#" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
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

        <!-- Top Header/Profile Bar (Fixed Top, Full Width) -->
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

        <!-- Main Content -->
        <main class="ml-64 mt-16 min-h-screen flex flex-col items-start justify-center pl-2 pr-4">
            <h2 class="text-5xl font-bold text-white mb-8">DASHBOARD</h2>
            <div class="w-full neon-frame p-6 mt-4 ml-0" style="max-width: 820px;">
                <h2 class="text-3xl font-bold text-white mb-8">Learning progress</h2>

                <!-- Progress Map (UI-only) -->
                <div
                x-data="progressMap()"
                x-init="init(@json($mapMilestones), {{ $overall }})"
                class="relative w-full h-64 mb-8 rounded-2xl overflow-hidden"
                style="background: url('{{ asset('asset/bg.png') }}') center/cover no-repeat;"
                >
                {{-- //Dark overlay  --}}
                <div class="absolute inset-0 bg-black opacity-30"></div>

                {{-- Invisible SVG path  --}}
                <svg viewBox="0 0 800 200" class="absolute inset-0 w-full h-full">
                    <path
                    x-ref="orbitPath"
                    d="M50,150 C200,20 600,20 750,150"
                    fill="none"
                    stroke="transparent"
                    stroke-width="2"
                    />
                </svg>

                 {{-- Planets  --}}
                <template x-for="(pct, idx) in percentages" :key="idx">
                    <div
                    @click="jumpTo(idx)"
                    class="absolute w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-teal-300
                            shadow-lg flex items-center justify-center text-xs text-white font-bold cursor-pointer"
                    :style="planetStyle(idx)"
                    x-text="`${pct}%`"
                    ></div>
                </template>

                {{-- Avatar --}}
              
                <img
                src="{{ asset('asset/avatars/' . (Auth::user()->avatar ?: 'default-avatar.png')) }}"
                alt="You are here"
                :class="`astronaut absolute w-12 ${jumping ? 'jump' : ''}`"
                :style="astronautStyle()"
                />
                </div> 
                
                @foreach($topics as $topic) 
                    <div class="mb-10">
                        <h3 class="text-2xl font-bold text-white mb-3">Topic {{ $loop->iteration }}</h3>
                        <span class="block font-bold text-lg text-gray mb-2">{{ strtoupper($topic->topic_title) }}</span>
                        <div class="progress-bar-group mb-6 group relative">
                            <div class="w-full rounded-full h-8 shadow-inner overflow-hidden relative progress-bg">
                                <div 
                                    class="progress-bar h-8 rounded-full flex items-center pl-4 transition-all duration-700 ease-in-out"
                                    style="width: {{ $topic->progress }}%;">
                                    <span class="text-white font-bold drop-shadow-lg animate-fade-in">{{ $topic->progress }}%</span>
                                    @if($topic->progress == 100)
                                        <span class="ml-3 animate-bounce text-yellow-300 drop-shadow-lg" title="Topic Complete!">🏆</span>
                                    @endif
                                </div>
                                <div class="progress-stripes pointer-events-none"></div>
                            </div>
                            <div class="progress-tooltip opacity-0 group-hover:opacity-100 transition bg-[#682E94] text-white px-4 py-2 rounded-xl absolute left-1/2 -translate-x-1/2 -top-12 z-10 text-sm font-bold shadow-lg pointer-events-none">
                                {{ $topic->progress }}% completed
                            </div>
                        </div>
                        @foreach($topic->exercises as $exercise)
                            <div class="bg-transparent border-b border-purple-300 py-4 px-2">
                                <span class="block text-lg text-white font-semibold">Exercise {{ $loop->iteration }}</span>
                                <span class="block text-white ml-4">
                                    Status:
                                    @if (isset($exercise->student_answer) && $exercise->student_answer->status === Answer::STATUS_3)
                                        <span class="text-green-400 font-bold ml-2">Completed</span>
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </main>

    </div>

<style>
html, body {
    height: 100%;
    width: 100%;
    background: #050e1a !important;
}

body {
    min-height: 100vh;
    min-width: 100vw;
    background: #050e1a !important;
}


.neon-frame {
    background: rgba(10, 10, 30, 0.90);
    border: 2px solid #15f7fc;
    border-radius: 24px;
    box-shadow:
        0 0 18px 3px #15f7fc,
        0 0 38px 1px #00bfff85 inset,
        0 0 28px 3px #19ffe7, 
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
.neon-frame h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1.3rem;
}
.neon-frame h3 {
    font-size: 1.7rem;
    font-weight: 700;
}
.progress-bar {
    background: linear-gradient(90deg, #11cdf7 0%, #13e2be 80%, #13bcff 100%);
    box-shadow: 0 2px 16px 0 #13bcff60, 0 1.5px 8px 0 #16ffd088;
    position: relative;
    min-width: 60px;
    font-size: 1rem;
    letter-spacing: 1px;
    border-radius: 9999px;
    transition: width 0.7s cubic-bezier(.4,2,.6,1);
}
.progress-bg {
    background: rgba(10,40,60,0.7) !important;
    border: 2px solid #15f7fc66;
    box-shadow: 0 0 12px #15f7fc33 inset;
}
.progress-stripes {
    pointer-events: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: repeating-linear-gradient(
        45deg, rgba(255,255,255,0.18) 0px, 
        rgba(255,255,255,0.15) 12px, 
        transparent 12px, 
        transparent 28px
    );
    animation: stripesMove 2s linear infinite;
    border-radius: 9999px;
    z-index: 1;
}
@keyframes stripesMove {
    0% { background-position: 0 0; }
    100% { background-position: 46px 0; }
}
.progress-tooltip {
    pointer-events: none;
    opacity: 0;
    background: #061928;
    border: 1.5px solid #15f7fc;
    color: #15f7fc;
    text-shadow: 0 0 6px #19ffe7;
    font-size: 1rem;
    transition: opacity 0.25s;
    white-space: nowrap;
    box-shadow: 0 0 15px #12e7e966, 0 2px 6px #12e7e933;
}
.group:hover .progress-tooltip {
    opacity: 1;
}
.animate-fade-in {
    animation: fadeIn 1s;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px);}
    to { opacity: 1; transform: translateY(0);}
}
.animate-bounce {
    animation: bounce 1.3s infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0);}
    50% { transform: translateY(-9px);}
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

/* progress map*/
.astronaut {
  transition: left 0.7s ease-out, top 0.7s ease-out;
}

/* Bounce animation */
@keyframes jump {
  0%, 100% { transform: translateY(0); }
  30%       { transform: translateY(-20px); }
}

.astronaut.jump {
  animation: jump 0.7s ease;
}


</style>
</x-app-layout>
