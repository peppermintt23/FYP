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
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
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
        <div class="py-12">
            <!-- Header Selectors -->
            <div class="flex justify-between mb-6">
                <div class="bg-[#A66FB5] text-white px-6 py-2 rounded-lg font-medium">
                    CDCS2662A
                </div>
                <div class="bg-[#A66FB5] text-white px-6 py-2 rounded-lg font-medium">
                    TOPIC 1
                </div>
            </div>

            <!-- Student Progress Table -->
            <div class="bg-[#F7F3F9] p-6 rounded-lg shadow">
                <table class="w-full table-auto text-gray-800">
                    <thead>
                        <tr class="text-left border-b border-gray-300">
                            <th class="py-3 px-4">STUDENT NAME</th>
                            <th class="py-3 px-4">STUDENT NUMBER</th>
                            <th class="py-3 px-4">LEARNING PROGRESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Asyraf Iskandar', 'Ammar', 'Adriana Natasya', 'Hamiza', 'Jessica', 'Khalid'] as $student)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4">{{ $student }}</td>
                            <td class="py-3 px-4">2022682980</td>
                            <td class="py-3 px-4">
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-[#A66FB5] h-4 rounded-full" style="width: {{ rand(30, 90) }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
