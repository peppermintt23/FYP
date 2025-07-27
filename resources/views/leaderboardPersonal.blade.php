
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
            <a href="#" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
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
    <main class="ml-64 mt-16 p-8 min-h-screen bg-transparent flex flex-col items-center justify-center">
        <div class="min-h-screen flex items-center justify-center bg-[#0a101a]">
        <div class="w-full max-w-2xl bg-[#15192b] rounded-2xl shadow-lg p-8 mx-auto border-4 border-cyan-400" style="box-shadow: 0 0 30px #00f0ff;">
            <div class="flex flex-col items-center mb-6">
                <div class="rounded-full border-4 border-cyan-400 p-2 mb-2" style="box-shadow: 0 0 15px #00f0ff;">
                    <img src="{{ $user->avatar ? asset('asset/avatars/' . $user->avatar) : asset('asset/avatars/default-avatar.png') }}"
                        class="w-24 h-24 rounded-full object-cover" alt="Avatar">
                </div>

                <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-lg text-cyan-400 font-bold">POINT : {{ $totalPoints }}</p>
            </div>

            <div class="text-center text-cyan-300 text-2xl mb-6 font-bold tracking-widest">PERSONAL LEADERBOARD</div>
            
            <div class="flex space-x-5 overflow-x-auto pb-4" style="scrollbar-color: #15f7fc33 #050e1a; scrollbar-width: thin;">
            @foreach($topics as $topic)
                <div class="bg-[#181d2f] rounded-xl border border-cyan-400 p-4 shadow"
                    style="box-shadow: 0 0 10px #00f0ff55; min-width: 300px; max-width: 320px; height: 340px; overflow-y:auto;">
                    <h3 class="text-cyan-300 text-lg font-bold mb-2 uppercase text-white">Topic {{ $loop->iteration }}</h3>
                    <div class="w-full">
                        <div class="grid grid-cols-7 gap-x-3 pb-2 mb-2 border-b border-cyan-900 font-semibold text-cyan-400 text-base">
                            <div class="col-span-3">Exercise</div>
                            <div class="col-span-2 text-center">Point</div>
                            <div class="col-span-1 text-right">Timer</div>
                        </div>
                        @foreach($topic->exercises as $exercise)
                            @php
                                $answer = $answers[$exercise->id] ?? null;
                                $score = $answer['student_score'] ?? 0;
                                $elapsed = ($answer && isset($answer['elapsed_time']) && $answer['elapsed_time'] !== null && $answer['elapsed_time'] !== '') 
                                    ? gmdate("H:i:s", $answer['elapsed_time']) 
                                    : "00:00:00";
                            @endphp
                            <div class="grid grid-cols-7 gap-x-3 py-2 mb-2 items-center rounded hover:bg-[#25365688] transition">
                                <!-- Exercise No + Title, wider column -->
                                <div class="col-span-3 text-white whitespace-normal break-words">
                                    <span class="font-bold text-cyan-300">Exercise {{ $loop->iteration }} : </span>
                                    
                                </div>
                                <div class="col-span-2 text-center text-cyan-200 font-bold">
                                    {{ $score }}
                                </div>
                                <div class="col-span-1 text-right text-xs text-gray-300 font-mono tracking-wide">
                                    {{ $elapsed }}
                                </div>
                            </div>
                        @endforeach
                    </div>


                    </div>
                @endforeach
            </div>

        </div>
    </div>
    </main>
</div>

<script>
        setInterval(function() {
        fetch("{{ route('student.leaderboard.personal.data') }}")
            .then(response => response.json())
            .then(data => {
                // Update tot   al points
                document.getElementById('total-point').innerText = "POINT : " + data.totalPoints;
                // Update name and avatar if needed
                document.getElementById('student-name').innerText = data.name;
                document.getElementById('student-avatar').src = `/asset/avatars/${data.avatar ?? 'default-avatar.png'}`;
                // Update topics & exercises
                let topicWrap = document.getElementById('topics-wrapper');
                topicWrap.innerHTML = ''; // clear old content

                data.topics.forEach(function(topic, tIdx) {
                    let topicBox = document.createElement('div');
                    topicBox.className = "bg-[#061928dd] border-2 border-[#15f7fc66] rounded-2xl p-5 shadow-lg neon-inner h-64 w-72 flex-shrink-0 overflow-y-auto scrollbar-thin scrollbar-thumb-[#15f7fc33]";
                    let html = `<h3 class="font-bold text-[#15f7fc] text-lg mb-3 tracking-widest">TOPIC ${tIdx + 1}</h3>`;
                    topic.exercises.forEach(function(ex, eIdx) {
                        let answer = data.answers[ex.id] ?? { student_score: 0, elapsed_time: 0 };
                        let point = answer.student_score ?? 0;
                        let elapsed = answer.elapsed_time ?? 0;

                        // Format elapsed time as HH:MM:SS
                        let h = Math.floor(elapsed / 3600);
                        let m = Math.floor((elapsed % 3600) / 60);
                        let s = elapsed % 60;
                        let timeStr = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;

                        html += `<div class="flex justify-between text-[#b3f3f8] text-base mb-2">
                                    <span>${ex.exercise_title}:</span>
                                    <span>${point} <span class="text-xs text-[#15f7fc99]">(${timeStr})</span></span>
                                </div>`;
                    });
                    topicBox.innerHTML = html;
                    topicWrap.appendChild(topicBox);
                });
            });
    }, 5000); // every 5 seconds

</script>

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

/* For webkit browsers */
::-webkit-scrollbar {
  width: 6px;
  height: 8px;
}
::-webkit-scrollbar-thumb {
  background: #15f7fc33;
  border-radius: 4px;
}

</style>
</x-app-layout>
