<x-app-layout>
    <div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
        <!-- Sidebar (Fixed Left) -->
        <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 ">
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
                <a href="#" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
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

        <!-- Main Content (Neon Card) -->
        <main class="ml-64 mt-16 min-h-screen flex flex-col items-start justify-center pl-2 pr-4">
            <div class="w-full neon-frame p-6 mt-4 ml-0 max-w-3xl">
                <h2 class="text-3xl text-white font-bold mb-6">Lecture Notes</h2>
                @foreach ($topics as $topic)
                    <div x-data="{ open: false }" class="mb-6">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center bg-[#101a2b] hover:bg-[#15213a] rounded-lg p-4 border border-[#15f7fc]/40 shadow-sm focus:outline-none transition">
                            <span class="text-lg font-semibold text-white">{{ $topic->topic_title }}</span>
                            <svg :class="open ? 'transform rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#15f7fc]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="mt-2 bg-[#08152a] rounded-lg border border-[#15f7fc]/20 shadow-inner">
                        @if ($topic->notes->isEmpty())
                            <p class="text-[#13e2be] p-4">No notes uploaded yet.</p>
                        @else
                            <ul class="divide-y divide-[#15f7fc]/20">
                                @foreach ($topic->notes as $note)
                                    <li class="flex justify-between items-center p-3">
                                        <span class="text-white">{{ basename($note->file_note) }}</span>
                                        <div class="space-x-2">
                                            <a href="{{ route('notes.show', $note->id) }}"
                                            target="_blank"
                                            class="neon-btn px-3 py-1">
                                            View
                                            </a>



                                            <a href="{{ route('notes.download', $note->id) }}"
                                            class="neon-btn px-3 py-1">
                                            Download
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    </div>
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

    aside.fixed nav a:hover,
    aside.fixed nav a.active {
        background: #142755bb;
        border-color: #15f7fc;
        color: #15f7fc;
        box-shadow: 0 0 10px #15f7fc44;
    }
    .neon-frame {
        background: rgba(10, 10, 30, 0.96);
        border: 3px solid #15f7fc;
        border-radius: 22px;
        box-shadow: 0 0 24px 5px #15f7fc, 0 0 44px 1px #00bfff85 inset, 0 0 0 9px #061928;
        position: relative;
        overflow: hidden;
    }
    .neon-btn {
        border: none;
        outline: none;
        color: #fff;
        font-weight: bold;
        border-radius: 8px;
        padding: 0.55rem 1.5rem;
        background: linear-gradient(90deg, #15f7fc 0%, #1344ea 100%);
        box-shadow: 0 0 10px #34f1ffd6;
        transition: background 0.22s, box-shadow 0.22s, color 0.16s, filter 0.22s;
        letter-spacing: 1px;
        cursor: pointer;
    }
    .neon-btn:hover {
        filter: brightness(1.13) saturate(1.4);
        box-shadow: 0 0 22px #15f7fc77;
        background: linear-gradient(90deg, #1344ea 0%, #15f7fc 100%);
        color: #fff;
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
        color: #18f6ff;
        box-shadow: 0 0 12px #18f6ff66;
    }
    aside.fixed {
        background: #0a132a;
        border-right: 4px solid #18f6ff;
        box-shadow: 0 0 36px 0 #18f6ff;
    }
    /* ambil dari exercise */
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
</x-app-layout>
