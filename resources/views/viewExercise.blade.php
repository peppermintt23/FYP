<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">

        <!-- Top Header -->
        <div class="bg-white shadow p-4 flex justify-end">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-800 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open"
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200">
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
        </div>

        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen w-64 bg-[#A66FB5] text-white p-6">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                <span class="text-2xl font-bold">CQPP</span>
            </div>

            <nav class="space-y-4">
                <a href="dashboard" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7..." />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('notes.index') }}" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="..." />
                    </svg>
                    <span>Notes</span>
                </a>
                <a href="{{ route('answer.index') }}" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="..." />
                    </svg>
                    <span>Exercise</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="..." />
                    </svg>
                    <span>Leaderboard</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto mt-10 bg-[#F7F3F9] text-white p-6 rounded-lg">
        @foreach ($topics as $topic)
            <div class="mb-4">
                <button onclick="toggleExercises({{ $topic->id }})" class="bg-[#A66FB5] text-white px-4 py-2 rounded">
                    {{ $topic->topic_title }}
                </button>

                <div id="exercises-{{ $topic->id }}" style="display: none;" class="mt-2">
                    @foreach ($topic->exercises as $exercise)
                        @php
                            $answer = optional($exercise->answers)->first();
                        @endphp


                        <div class="bg-[#F7F3F9] text-black p-4 rounded mb-2">
                            <p><strong>{{ $exercise->exercise_title }}</strong></p>
                            <p><strong>Status:</strong> {{ $answer ? 'Completed' : 'Not Answer Yet' }}</p>

                            <div class="mt-2 space-x-2">
                                <a href="{{ route('answer.show', $exercise->id) }}" class="bg-blue-500 px-3 py-1 rounded">Answer</a>
                            
                                <a href="{{ route('answer.feedback', $exercise->id) }}" class="bg-green-500 px-3 py-1 rounded">View Feedback</a>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <script>
        function toggleExercises(topic_id) {
            const div = document.getElementById('exercises-' + topic_id);
            div.style.display = div.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</x-app-layout>
