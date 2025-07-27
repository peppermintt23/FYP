<x-app-layout>
    <div class="min-h-screen bg-[#050e1a] text-white">
        <!-- Top Header -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-cyan-200 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-[#0f172a] border border-cyan-400 rounded shadow-md divide-y divide-gray-200 z-50">
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-cyan-200 hover:bg-cyan-900 hover:text-white">
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
        <main class="ml-64 pt-24 min-h-screen flex flex-col">
            <div class="w-full max-w-3xl neon-frame p-4 ml-0">
                <h2 class="text-3xl font-semibold mb-4 text-center text-cyan-300">Learning Material</h2>

                <form method="POST" action="{{ route('topics.store') }}" class="mb-6 flex space-x-2 justify-center">
                    @csrf
                    <input type="text" name="topic_title" required placeholder="New Topic" class="neon-input flex-grow max-w-xs">
                    <button type="submit" class="neon-btn bg-[#7d5fff]">Add Topic</button>
                </form>

                @if($topics->isEmpty())
                    <p class="text-center text-cyan-200">No topics found.</p>
                @else
                    @foreach ($topics as $topic)
                        <div class="mb-8 border-b border-cyan-600 pb-4">
                            <h3 class="text-2xl font-bold mb-2 text-cyan-100">{{ $topic->topic_title }}</h3>
                            <form method="POST" action="{{ route('topics.destroy', $topic) }}" class="mb-2 inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="neon-btn bg-gradient-to-r from-pink-500 to-red-600 hover:from-red-500 hover:to-pink-500">Delete Topic</button>
                            </form>
                            <form method="POST" action="{{ route('notes.store', $topic) }}" enctype="multipart/form-data" class="mb-2 flex space-x-2">
                                @csrf
                                <input type="file" name="file_note" required class="neon-input flex-grow">
                                <button type="submit" class="neon-btn bg-[#12d8fa]">Upload Note</button>
                            </form>
                            <ul class="list-disc list-inside text-cyan-200 mt-3">
                            @foreach ($topic->notes as $note)
                                <li class="mb-1 flex justify-between items-center">
                                <span class="flex-1">
                                    {{ basename($note->file_note) }}
                                </span>
                                <div class="flex space-x-2">
                                    <!-- View button -->
                                    <a href="{{ route('notes.show', $note) }}" target="_blank"
                                    class="neon-btn py-1 px-3 bg-green-500 hover:bg-green-600">
                                    View
                                    </a>

                                    <!-- Delete button -->
                                    <form method="POST" action="{{ route('notes.destroy', $note) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="neon-btn py-1 px-3 bg-transparent border border-pink-400 text-pink-400 hover:text-pink-600">
                                        Delete
                                    </button>
                                    </form>
                                </div>
                                </li>
                            @endforeach
                            </ul>

                        </div>
                    @endforeach
                @endif
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
        background: linear-gradient(160deg, #0a132a 70%, #14e1ee3c 100%);
        border-right: 3.5px solid #13e2be;
        box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
    }
    aside.fixed .text-2xl {
            color: #13e2be !important;
            text-shadow: 0 0 8px #13e2be77;
        }
    .neon-frame span,
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
    </style>
</x-app-layout>
