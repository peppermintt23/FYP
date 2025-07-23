<x-app-layout>
    <div class="min-h-screen bg-[#050e1a] text-white">
        <!-- Top Header -->
        <div class="bg-[#071c2d] px-8 py-4 flex justify-end shadow z-40 fixed left-0 right-0 top-0">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-cyan-200 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-[#101b2a] border border-cyan-400 rounded shadow-md divide-y divide-gray-200 z-50">
                    <div class="py-1">
                        <a href="{{ route('lecturer.profile.view') }}" class="block px-4 py-2 text-sm text-cyan-200 hover:bg-cyan-900 hover:text-white">
                            Profile
                        </a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-cyan-200 hover:bg-cyan-900 hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen w-64 neon-sidebar text-white p-6 pt-8 z-50">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                <span class="text-2xl font-bold text-[#13e2be]">CQPP</span>
            </div>
            <nav class="space-y-4">
                <a href="dashboard" class="sidebar-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manage.notes') }}" class="sidebar-link">
                    <span>Manage Learning Material</span>
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

        <!-- Main Content Wrapper -->
        <main class="ml-64 pt-24 px-0 flex min-h-screen justify-start gap-x-2">
           
            <div class="w-full max-w-3xl p-0 mt-6">
                
                <div class="relative neon-frame p-8">
                    
                    <!-- Close Button -->
                    <a href="{{ route('exercises.manage') }}"
                        class="absolute top-4 right-4 text-[#15f7fc] bg-[#071c2d] border-2 border-cyan-400 hover:bg-[#0a2239] hover:text-white px-4 py-2 rounded-xl shadow transition duration-150 z-50 text-3xl flex items-center justify-center"
                        style="line-height: 1;">
                        &times;
                    </a>

                    @if(session('success'))
                        <div class="bg-[#0e5246] text-[#12ffb7] border-l-4 border-[#13e2be] p-4 rounded text-sm mb-4 shadow-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-3xl font-bold mb-6 text-cyan-300">
                        Create Exercise for "{{ $topic->topic_title }}"
                    </h2>

                    <form action="{{ route('exercises.store', $topic->id) }}" method="POST">
                        @csrf

                        <!-- Exercise Title -->
                        <label class="block mb-2 font-bold text-cyan-200">Exercise Title</label>
                        <input type="text" name="exercise_title" class="w-full neon-input mb-5" required>

                        <!-- Question -->
                        <label class="block mb-2 font-bold text-cyan-200">Question</label>
                        <textarea name="question" rows="4" class="w-full neon-input mb-5" required></textarea>

                        <!-- Expected Output -->
                        <label class="block mb-2 font-bold text-cyan-200">Expected Output</label>
                        <input type="text" name="expected_output" class="w-full neon-input mb-5" required>

                        <!-- Hint -->
                        <label class="block mb-2 font-bold text-cyan-200">Hint (Optional)</label>
                        <textarea name="hint" rows="2" class="w-full neon-input mb-5"></textarea>

                        <!-- Score -->
                        <label class="block mb-2 font-bold text-cyan-200">Score</label>
                        <input type="number" name="score" min="0" class="w-full neon-input mb-5" required>

                        <!-- has_guideline -->
                        <label for="has_guideline" class="block mb-2 font-bold text-cyan-200">Do you want to add guidelines?</label>
                        <select name="has_guideline" id="has_guideline" class="w-full neon-input mb-8">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                        <div>
                            <button type="submit" class="neon-btn bg-gradient-to-r from-[#15f7fc] to-[#1de9b6]">
                                Create Exercise
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

    </div>

    <!-- Neon Styles -->
    <style>
        html, body {
            background: #050e1a !important;
            min-height: 100vh;
            width: 100vw;
        }
        .neon-frame {
            background: rgba(10, 10, 30, 0.98);
            border: 3px solid #15f7fc;
            border-radius: 22px;
            box-shadow: 0 0 24px 5px #15f7fc, 0 0 44px 1px #00bfff85 inset, 0 0 0 9px #061928;
            position: relative;
            overflow: hidden;
        }
        .neon-input {
            border: 1.5px solid #15f7fc;
            background: #071c2d;
            color: #c9fbff;
            border-radius: 8px;
            padding: 0.7rem 1.2rem;
            outline: none;
            font-size: 1.08rem;
            transition: border 0.2s, box-shadow 0.2s;
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
            border-radius: 8px;
            padding: 0.6rem 2rem;
            box-shadow: 0 0 10px #14e1ee44;
            transition: background 0.22s, box-shadow 0.22s, color 0.16s, filter 0.22s;
            letter-spacing: 1px;
            cursor: pointer;
        }
        .neon-btn:hover {
            filter: brightness(1.13) saturate(1.4);
            box-shadow: 0 0 22px #15f7fc77;
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
        .neon-sidebar {
            background: #0a132a;
            border-right: 3.5px solid #13e2be;
            box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
        }
        .neon-step {
            background: rgba(10, 40, 60, 0.82);
            border: 2px solid #15f7fc66;
            border-radius: 16px;
            box-shadow: 0 2px 16px #13bcff44;
        }
    </style>
</x-app-layout>
