<x-app-layout>
<div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
    <!-- Sidebar (Fixed Left) -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50">
        <div class="mb-8 flex items-center space-x-3">
            <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
            <span class="text-2xl font-bold text-[#13e2be]">CQPP</span>
        </div>
        <aside class="fixed left-0 top-0 h-screen w-64 neon-sidebar text-white p-6 pt-8 z-50">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                <span class="text-2xl font-bold text-[#13e2be]">CQPP</span>
            </div>
            <nav class="space-y-4">
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manage.notes') }}" class="sidebar-link">
                    <span>Manage Note</span>
                </a>
                <a href="{{ route('exercises.manage', $topic->id ?? 1) }}" class="sidebar-link">
                    <span>Manage Exercise</span>
                </a>
                <a href="{{ route('leaderboard.lecturer') }}" class="sidebar-link">
                    <span>Leaderboard</span>
                </a>
                <a href="#" class="sidebar-link">
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>
       

    <!-- Top Header/Profile Bar (Fixed Top, Full Width) -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
                <span class="font-semibold">Shakirah</span>
                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200 z-50">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                </div>
                <div class="py-1">
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <a href="{{ route('leaderboard.lecturer') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Leaderboard</span>
                </a>

    <!-- Main Content -->
    <main class="ml-64 pt-24 px-8 min-h-screen flex flex-col items-center">
        <div class="w-full max-w-2xl neon-frame p-8 mt-4">
            <!-- Profile Section -->
            <div class="flex flex-col md:flex-row items-center gap-8 mb-10">
                <div class="w-24 h-24 rounded-full border-4 border-[#15f7fc] flex items-center justify-center shadow-xl bg-[#061928]">
                    <!-- Lecturer image -->
                    <img src="{{ asset('asset/lecturer.png') }}" alt="avatar" class="w-20 h-20 rounded-full">
                </div>
                <div class="flex-1 flex flex-col items-center md:items-start">
                    <div class="bg-[#071c2d] border border-[#13e2be] text-white rounded-lg px-5 py-3 mb-2 shadow">
                        <span class="font-bold text-lg">{{ Auth::user()->name ?? 'Lecturer Name' }}</span><br>
                        <span class="text-base text-[#15f7fc]">{{ Auth::user()->staff_id ?? 'STAFF ID' }}</span>
                    </div>
                    <button class="edit-btn mt-2">EDIT</button>
                </div>
            </div>
            
            <!-- List of Class -->
            <div class="text-lg font-bold text-[#13e2be] mb-3">LIST OF CLASS</div>
            <div class="bg-[#101b2a] border-2 border-[#15f7fc66] rounded-xl shadow p-6">
                <!-- Example list, replace with @foreach for real data -->
                <div class="flex flex-col gap-4">
                    <div class="flex flex-row items-center justify-between border-b border-[#15f7fc22] pb-4 mb-4 last:border-b-0 last:mb-0 last:pb-0">
                        <a href="#" class="class-link text-[#15f7fc] font-semibold underline underline-offset-4 hover:text-[#13e2be]">CDCS2662A</a>
                        <a href="#" class="view-leaderboard-btn">VIEW LEADERBOARD</a>
                    </div>
                    <div class="flex flex-row items-center justify-between border-b border-[#15f7fc22] pb-4 mb-4 last:border-b-0 last:mb-0 last:pb-0">
                        <a href="#" class="class-link text-[#15f7fc] font-semibold underline underline-offset-4 hover:text-[#13e2be]">CDCS2402C</a>
                        <a href="#" class="view-leaderboard-btn">VIEW LEADERBOARD</a>
                    </div>
                    <div class="flex flex-row items-center justify-between">
                        <a href="#" class="class-link text-[#15f7fc] font-semibold underline underline-offset-4 hover:text-[#13e2be]">CDCS2662B</a>
                        <a href="#" class="view-leaderboard-btn">VIEW LEADERBOARD</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
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
</style>
</x-app-layout>
