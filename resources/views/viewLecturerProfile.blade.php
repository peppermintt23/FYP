<x-app-layout>
<div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 neon-sidebar">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-12 h-12">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="#" class="flex items-center space-x-3 sidebar-link">
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

    <!-- Main Content -->
    <main class="ml-64 pt-24 px-8 min-h-screen flex flex-col items-center">
        <div class="w-full max-w-2xl neon-frame p-8 mt-4">
            <!-- Profile Section -->
            <div class="flex flex-col items-center justify-center gap-5 mb-10 w-full">
                <div class="bg-[#071c2d] border border-[#13e2be] text-white rounded-xl px-8 py-6 shadow-lg flex flex-col items-center w-50 max-w-md">
                    <span class="font-bold text-2xl mb-5">{{ $lecturer->name ?? '-' }}</span>
                    <span class="text-base text-[#15f7fc] mb-5">Staff ID: {{ $lecturer->staff_number ?? '-' }}</span>
                    <span class="text-base text-[#13e2be] mb-5">Room: {{ $lecturer->room_number ?? '-' }}</span>
                    <a href="{{ route('lecturer.profile.edit', ['lecturer' => $lecturer->id]) }}" class="edit-btn mt-4 self-center w-40 text-center">
                        Edit Profile
                    </a>
                </div>
            </div>


            <!-- List of Class -->
            <div class="text-lg font-bold text-[#13e2be] mb-3">LIST OF CLASS</div>
            <div class="bg-[#101b2a] border-2 border-[#15f7fc66] rounded-xl shadow p-6">
                <div class="flex flex-col gap-4">
                    @forelse($classes as $class)
                        <div class="flex flex-row items-center justify-between border-b border-[#15f7fc22] pb-4 mb-4 last:border-b-0 last:mb-0 last:pb-0">
                            <p class="text-[#15f7fc] font-semibold  underline-offset-4">
                                {{ $class->groupCourse }}
                            </p>
                            <a href="{{ route('leaderboard.lecturer', ['groupCourse' => $class->groupCourse]) }}" class="edit-btn">
                                LEADERBOARD
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-[#15f7fc] py-6">No class assigned.</div>
                    @endforelse
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
    .neon-frame {
        background: rgba(10, 10, 30, 0.98);
        border: 3px solid #15f7fc;
        border-radius: 18px;
        box-shadow: 0 0 18px 3px #15f7fc, 0 0 38px 1px #15f7fc44 inset, 0 0 0 7px #061928;
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
    .edit-btn {
        background: #0bffe7;
        color: #09304d;
        border: none;
        border-radius: 8px;
        padding: 7px 20px;
        font-size: 1rem;
        font-weight: bold;
        box-shadow: 0 0 8px #0fffc788;
        cursor: pointer;
        transition: 0.18s;
        letter-spacing: 1px;
    }
    .edit-btn:hover {
        background: #13e2be;
        color: #fff;
        box-shadow: 0 0 16px #15f7fcbb;
    }
    .view-leaderboard-btn {
        background: linear-gradient(90deg, #15f7fc 60%, #12e0be 100%);
        color: #0a2431;
        padding: 7px 19px;
        border-radius: 7px;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        box-shadow: 0 0 7px #15f7fc66;
        cursor: pointer;
        transition: 0.18s;
        text-decoration: none !important;
        display: inline-block;
    }
    .view-leaderboard-btn:hover {
        background: linear-gradient(90deg, #13e2be 40%, #15f7fc 100%);
        color: #fff;
        box-shadow: 0 0 20px #15f7fc88;
    }
    .class-link {
        font-size: 1.15rem;
    }
    @keyframes movingbg {
            from { background-position-x: 0; }
            to   { background-position-x: 200px; }
        }
    .neon-frame {
        background: rgba(10, 10, 30, 0.97);
        border: 3px solid #15f7fc;
        border-radius: 22px;
        box-shadow: 0 0 24px 5px #15f7fc, 0 0 44px 1px #00bfff85 inset, 0 0 0 9px #061928;
        position: relative;
        overflow: hidden;
    }
    aside.fixed .text-2xl {
            color: #13e2be !important;
            text-shadow: 0 0 8px #13e2be77;
        }
    .neon-frame span,
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
    .neon-input {
        border: 1.5px solid #15f7fc;
        background: #071c2d;
        color: #c9fbff;
        border-radius: 8px;
        padding: 0.7rem 1.2rem;
        outline: none;
        font-size: 1.1rem;
    }
    .neon-input:focus {
        border: 2px solid #14e1ee;
        background: #0a132a;
        color: #00fff3;
        box-shadow: 0 0 12px #19ffe799;
    }

</style>
</x-app-layout>
