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
                        <a href="{{ route('lecturer.profile.view') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                <a href="student-dashboard" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span>List of classes</span>
                </a>

                <a href="{{ route('manage.notes') }} "
                    class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span>Manage Notes</span>
                </a>
                <a href="{{ route('exercises.manage', $topic->id ?? 1) }}"
                    class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <span>Manage Exercise</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Leaderboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="ml-64 p-8 flex justify-center">
            <!-- Inner content container -->

            <!-- Close Button -->
            <a href="{{ route('exercises.manage') }}"
                class="absolute top-4 right-4 text-gray-600 bg-gray-200 hover:bg-gray-400 hover:text-white px-4 py-2 rounded-lg shadow transition duration-150 z-50">
                &times;
            </a>

            <div class="w-full max-w-4xl mx-auto p-6 bg-white rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Edit Exercise</h2>

                @if (session('success'))
                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('exercises.update', $exercise->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Exercise Title</label>
                        <input type="text" name="exercise_title"
                            value="{{ old('exercise_title', $exercise->exercise_title) }}"
                            class="w-full px-4 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Question</label>
                        <textarea name="question" class="w-full px-4 py-2 border rounded" required>{{ old('question', $exercise->question) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Hint (optional)</label>
                        <input type="text" name="hint" value="{{ old('hint', $exercise->hint) }}"
                            class="w-full px-4 py-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Score</label>
                        <input type="number" name="score" value="{{ old('score', $exercise->score) }}"
                            class="w-full px-4 py-2 border rounded" min="0" required>
                    </div>
                    <label for="has_guideline" class="block mb-2 font-semibold text-gray-700">Do you want to add
                        guidelines?</label>
                    <select name="has_guideline" id="has_guideline"
                        class="w-full p-3 mb-5 border rounded focus:outline-none focus:ring focus:border-blue-300">
                        <option value="No"
                            {{ old('has_guideline', $exercise->has_guideline) == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes"
                            {{ old('has_guideline', $exercise->has_guideline) == 'Yes' ? 'selected' : '' }}>Yes
                        </option>
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update
                        Exercise</button>
                </form>
                <br><br>
                @if (old('has_guideline', $exercise->has_guideline) == 'Yes')
                    <!-- Guidelines -->
                    <fieldset style="background: #eee;padding:20px">
                        <label class="block mb-1 font-medium">Guidelines (Step-by-step)</label>

                        <div id="guideline-steps" class="mb-4">
                            @foreach ($exercise->guidelines as $index => $guideline)
                                <form method="POST" action="{{ route('exercises.update_guideline', ['exercise' => $exercise->id, 'guideline' => $guideline->id]) }}">
    @csrf
    @method('PUT')

                                    <div class="step p-4 border border-gray-300 rounded-md bg-gray-50">
                                        <label class="block mb-2 font-semibold text-gray-600">Step Number</label>
                                        <input type="text" name="guidelines[{{ $index }}][step_number]"
                                            value="{{ old('guidelines.' . $index . '.step_number', $guideline->step_number) }}"
                                            class="w-full p-2 mb-4 border rounded" required>

                                        <label class="block mb-2 font-semibold text-gray-600">Step Description</label>
                                        <input type="text"
                                            name="guidelines[{{ $index }}][step_description]"
                                            value="{{ old('guidelines.' . $index . '.step_description', $guideline->step_description) }}"
                                            class="w-full p-2 mb-4 border rounded" required>

                                        <label class="block mb-2 font-semibold text-gray-600">Expected Code</label>
                                        <textarea name="guidelines[{{ $index }}][expected_code]" rows="4" class="w-full p-2 border rounded"
                                            required>{{ old('guidelines.' . $index . '.expected_code', $guideline->expected_code) }}</textarea>
                                        <button type="submit" style="float:right"
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update
                                            </button>
                                </form>
                                <form method="POST"
                                    action="{{ route('exercises.destroy_guideline', ['exercise' => $exercise->id, 'guideline' => $guideline->id]) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this guideline?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mt-2">Delete</button>
                                </form>
                        </div>
                @endforeach
            </div>

            <!-- Add Step Button -->
            <form method="POST" action="{{ route('exercises.create_guideline', $exercise->id) }}">
                @csrf
                <div class="step p-4 border border-gray-300 rounded-md bg-gray-50 mb-4">
                    <label class="block mb-2 font-semibold text-gray-600">Step Number</label>
                    <input type="number" name="step_number" min="1" value="{{ $exercise->guidelines->count() + 1 }}"
                        class="w-full p-2 mb-4 border rounded">

                    <label class="block mb-2 font-semibold text-gray-600">Step Description</label>
                    <input type="text" name="step_description" class="w-full p-2 mb-4 border rounded">

                    <label class="block mb-2 font-semibold text-gray-600">Expected Code</label>
                    <textarea name="expected_code" rows="4" class="w-full p-2 border rounded"></textarea>
                    <button type="submit"
                        class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition duration-150 ease-in-out mb-6">
                        + Add Step
                    </button>
                </div>

            </form>
            @endif
            <fieldset>

    </div>

    <script>
        let stepIndex = {{ count($exercise->guidelines) }}; // Start index from the number of existing guidelines

        function addStep() {
            const container = document.getElementById('guideline-steps');

            const stepHTML = `
                        <div class="step p-4 border border-gray-300 rounded-md bg-gray-50 mb-4">
                            <label class="block mb-2 font-semibold text-gray-600">Step Number</label>
                            <input type="text" name="guidelines[${stepIndex}][step_number]" class="w-full p-2 mb-4 border rounded" required>

                            <label class="block mb-2 font-semibold text-gray-600">Step Description</label>
                            <input type="text" name="guidelines[${stepIndex}][step_description]" class="w-full p-2 mb-4 border rounded" required>

                            <label class="block mb-2 font-semibold text-gray-600">Expected Code</label>
                            <textarea name="guidelines[${stepIndex}][expected_code]" rows="4" class="w-full p-2 border rounded" required></textarea>
                        </div>
                    `;

            container.insertAdjacentHTML('beforeend', stepHTML);
            stepIndex++;
        }
    </script>
    </main>
    </div>
</x-app-layout>
