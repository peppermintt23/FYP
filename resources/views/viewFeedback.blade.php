{{-- <x-app-layout>
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
        <div class="relative max-w-4xl mx-auto mt-10 bg-purple-900/30 text-white p-6 rounded-lg">
                
            <!-- Close Button -->
            <a href="{{ route('answer.index') }}" 
                class="absolute top-4 right-4 text-white text-3xl font-bold hover:text-red-400"
                title="Close">
                &times;
            </a>

            <h2 class="text-2xl font-semibold mb-4">Output</h2>

            <p class="mb-4"><strong>Your Answers:</strong></p>
            
            @if($parentAnswer && $parentAnswer->answer)
                <div class="mb-2">
                    <strong>Compiled Code:</strong>
                    <pre class="bg-gray-800 text-white p-4 rounded">{{ $parentAnswer->answer }}</pre>
                </div>
            @endif


            @forelse($answers as $ans)
                <div class="mb-2">
                    <strong>Step {{ $ans->step_number }}:</strong>
                    <pre class="bg-gray-200 text-black p-4 rounded">{{ $ans->answer }}</pre>
                </div>
            @empty
                <pre class="bg-gray-800 text-white p-4 rounded">No answers submitted.</pre>
            @endforelse

            <p class="mt-4"><strong>Score:</strong> {{ $parentAnswer->student_score ?? 'Pending' }}</p>
            <p class="mt-2"><strong>Lecturer Feedback:</strong> {{ $parentAnswer->feedback ?? 'No feedback yet.' }}</p>
        </div>
    </div>
</x-app-layout> --}}