<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <!-- Top Header -->
        <div class="bg-white p-4 flex justify-end">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-800 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white rounded shadow-md divide-y divide-gray-200">
                    <div class="py-1">
                        <a href="{{ route('lecturer.profile.view'       ) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
        </div>

        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen w-64 bg-[#A66FB5] text-white p-6">
            <!-- Logo Area -->
            <div class="mb-8">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                    <span class="text-2xl font-bold text-white">CQPP</span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-4">
                <a href="dashboard" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>List of classes</span>
                </a>

                <a href="{{ route('manage.notes') }}" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Manage Notes</span>
                </a>
                <a href="{{ route('exercises.manage', $topic->id ?? 1) }}" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Manage Exercise</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Leaderboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>

         <!-- Main Content Wrapper -->
        <main class="py-12 flex justify-center">
            <!-- Inner content container -->
            <div class="w-full max-w-4xl bg-[#F7F3F9] p-8 rounded shadow">
                <h2 class="text-2xl font-semibold mb-4 text-center">Topics</h2>

                <form method="POST" action="{{ route('topics.store') }}" class="mb-6 flex space-x-2 justify-center">
                    @csrf
                    <input type="text" name="topic_title" required placeholder="New Topic" class="border rounded px-3 py-1 flex-grow max-w-xs">
                    <button type="submit" class="bg-purple-700 text-white px-4 rounded hover:bg-purple-800">Add Topic</button>
                </form>

                @if($topics->isEmpty())
                    <p class="text-center text-gray-600">No topics found.</p>
                @else
                    @foreach ($topics as $topic)
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-xl font-medium mb-2">{{ $topic->topic_title }}</h3>

                            <form method="POST" action="{{ route('topics.destroy', $topic) }}" class="mb-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete Topic</button>
                            </form>

                            <form method="POST" action="{{ route('notes.store', $topic) }}" enctype="multipart/form-data" class="mb-2 flex space-x-2">
                                @csrf
                                <input type="file" name="file_note" required class="border rounded px-2 py-1 flex-grow">
                                <button type="submit" class="bg-green-600 text-white px-4 rounded hover:bg-green-700">Upload Note</button>
                            </form>

                            <ul class="list-disc list-inside">
                                @foreach ($topic->notes as $note)
                                <li class="mb-1 flex justify-between items-center">
                                    <a href="{{ Storage::url($note->file_note) }}" target="_blank" class="text-purple-700 hover:underline">
                                        {{ basename($note->file_note) }}
                                    </a>
                                    <form method="POST" action="{{ route('notes.destroy', $note) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>
    </div>
</x-app-layout>