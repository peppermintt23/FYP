<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <!-- Top Header -->
        <div class="bg-white p-4 flex justify-end">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-800 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded shadow-md divide-y divide-gray-200">
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('exercises.manage') }}" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Manage Exercise</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="ml-64 p-8 flex justify-center">
            <div class="w-full max-w-4xl mx-auto p-6 bg-white rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Evaluate Student Answer</h2>

                @if (session('success'))
                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('answers.submit', $answer->id) }}">
                    @csrf

                    <!-- Display Student Answer -->
                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Student Answer</label>
                        <textarea class="w-full px-4 py-2 border rounded" rows="6" readonly>{{ $answer->answer }}</textarea>
                    </div>

                    <!-- Lecturer Input for Evaluation -->
                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Evaluate Student Answer</label>
                        <textarea name="feedback" class="w-full px-4 py-2 border rounded" rows="6" placeholder="Provide feedback here..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Mark the answer (Optional)</label>
                        <input type="number" name="marks" min="0" max="100" class="w-full px-4 py-2 border rounded" placeholder="Enter marks out of 100">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Evaluation</button>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
