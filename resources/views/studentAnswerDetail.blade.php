@php
    use App\Models\Answer;
@endphp
<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">

        <!-- Top Header -->
        <div class="bg-white shadow p-4 flex justify-end">
            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-800 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200">
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
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
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('notes.index') }}"
                    class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <span>Notes</span>
                </a>
                <a href="{{ route('answer.index') }}"
                    class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <span>Exercise</span>
                </a>
                <a href="{{ route('leaderboard.lecturer') }}" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                    <span>Leaderboard</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 p-8 flex justify-center" style="margin-top:-70px;margin-left:30px">
            <div class="w-full max-w-5xl mx-auto bg-white p-8 shadow-lg rounded-lg mt-10">

                <!-- Question Section -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Exercise: {{ $exercise->exercise_title }}</h2>
                    <p class="mb-4"><strong>Question:</strong> {{ $exercise->question }}</p>
                </div>

                <div class="bg-gray-100 p-6 rounded-lg">
                    <b>Expected output:
                        <span class="text-blue-600">{{ $exercise->expected_output }}</span>
                    </b>

                    <!-- Hint -->
                    <div class="mb-6 mt-4">
                        <strong class="text-lg">Hint:</strong>
                        @if ($exercise->hint)
                            <p class="text-gray-700">{{ $exercise->hint }}</p>
                        @else
                            <p class="text-gray-700">No hint available for this exercise.</p>
                        @endif
                    </div>
                    <!-- Submission or Feedback logic -->
                    @if (($existingAnswer && $existingAnswer->status != Answer::PENDING_STATUS))
                        <!-- Show Submission Form -->
                        <form action="{{ route('answer.submitExercise', $exercise->id) }}" method="POST">
                            @csrf
                            @foreach ($exercise->guidelines as $index => $guideline)
                                <div class="mb-4 p-4 border border-gray-300 rounded-md bg-gray-50">
                                    <p><strong>Step {{ $guideline->step_number }}:</strong>
                                        {{ $guideline->step_description }}</p>

                                    <label for="student_answer_{{ $guideline->step_number }}" class="block mt-4">Your
                                        Answer:</label>
                                    <textarea name="student_answer[{{ $guideline->step_number }}]" rows="6"
                                        class="w-full bg-white text-black p-2 rounded" required></textarea>
                                </div>
                            @endforeach

                            <button type="submit" class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Submit
                                Answer</button>
                        </form>

                    @elseif (($existingAnswer && $existingAnswer->status == Answer::PENDING_STATUS) || ($submittedGuideline && $submittedGuideline->status == Answer::STATUS_1) || ($submittedCode && $submittedCode->status == Answer::STATUS_2))
                    
                        <!-- Show Student Answer and Code Run if Needed -->

                        <p class="mt-2 font-semibold text-green-600">
                            ✅ You have already submitted this answer.
                        </p>
                        <br>
                        Guidelines :

                        @foreach ($exercise->guidelines as $index => $guideline)
                            @php
                                $guidelineAnswer = \App\Models\Answer::where('student_id', $studentId)
                                    ->where('exercise_id', $exercise->id)
                                    ->where('step_number', $guideline->step_number)
                                    ->where('category', 'Non-Compiler')
                                    ->first();
                                $studentCode = trim($guidelineAnswer?->answer ?? '');
                                $expectedCode = trim($guideline->expected_code);
                                $isPass = $studentCode === $expectedCode;
                            @endphp

                            <div class="mb-4 p-4 border border-gray-300 rounded-md bg-gray-50">
                                <p><strong>Step {{ $guideline->step_number }}:</strong>
                                    {{ $guideline->step_description }}</p>
                                <p>Expected Code: <span class="text-blue-600">{{ $expectedCode }}</span></p>

                                <label class="block mt-4">Your Answer:</label>
                                <pre class="bg-white p-2 rounded border">{{ $studentCode ?: '-' }}</pre>

                                <p class="mt-2 font-semibold">
                                    Result:
                                    <span class="{{ $isPass ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $isPass ? '✅ Correct' : '❌ Not Match' }}
                                    </span>
                                </p>
                            </div>
                        @endforeach

                        <!-- Compiler-based answer: show code run form -->
                        @php
                            $existing = \App\Models\Answer::where('student_id', $studentId)
                                ->where('exercise_id', $exercise->id)
                                ->where('category', 'Need-Compiler')
                                ->first();
                            $studentCode = $existing?->answer ?? '';
                        @endphp

                        @if ($existing && ($submittedGuideline && $submittedGuideline->status == Answer::STATUS_1))
                            <form method="POST" action="{{ route('cpp.run') }}">
                                @csrf
                                <input type="hidden" name="exercise_id" value="{{ $exercise->id }}" />

                                <label class="block mt-4 mb-2 font-semibold">Your Code:</label>
                                <textarea name="code" rows="10" class="w-full p-2 bg-white text-black rounded" required>{{ $studentCode }}</textarea>

                                <button type="submit" class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Run
                                    Code</button>
                            </form>
                        @endif

                        @if (session('compiler_status'))
                            @php
                                $actualOutput = trim(session('compiler_output'));
                                $expectedOutput = trim($exercise->expected_output);
                                $isPass = $actualOutput === $expectedOutput;
                                $outputColor = $isPass ? 'text-blue-600' : 'text-red-600';
                            @endphp

                            <hr class="my-6">
                            <h3 class="text-xl font-bold">Output:</h3>
                            <pre class="bg-gray-200 p-4 rounded text-sm whitespace-pre-wrap {{ $outputColor }}">
                                {{ session('compiler_output') }}
                            </pre>
                            <p class="mt-2"><strong>Compiler Status:</strong> {{ session('compiler_status') }}</p>

                            <p class="mt-2 font-semibold">
                                Result:
                                <span class="{{ $isPass ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $isPass ? '✅ Pass, Congrats!' : '❌ Not Pass, Please Check your code again!' }}
                                </span><br>
                                <span>Score : {{ $existing?->student_score }}/20</span>
                            </p>
                             <form action="{{ route('answer.submitFinalExercise', $exercise->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="category" value="Need-Compiler" />
                                    <button type="submit" class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Submit
                                        Answer</button>
                                </form>
{{-- lepas submit code --}}

@elseif ($submittedCode && $submittedCode->status == Answer::STATUS_2)
                        <!-- Graded/Feedback view -->
                        @php
                            $existing = \App\Models\Answer::where('student_id', $studentId)
                                ->where('exercise_id', $exercise->id)
                                ->where('category', 'Need-Compiler')
                                ->where('status', Answer::STATUS_2)
                                ->first();
                            $studentCode = $existing?->answer ?? '';
                        @endphp

                        <div class="mb-4 mt-2">
                            <strong class="block mb-1 text-gray-800">Submitted Answer:</strong>
                            <pre class="bg-gray-200 p-4 rounded text-sm whitespace-pre-wrap">
                                {{ $studentCode }}
                            </pre>
                        </div>

                        <p class="mt-2 font-semibold">
                            Result #<span>Score : {{ $existing?->student_score ?? 0 }}/20</span>
                        </p>
                        <br>
                        @if ($submittedCode->status == Answer::STATUS_2 && Auth::user()->role == 'lecturer')
                            <form action="{{ route('answer.submitFeedback', $exercise->id) }}" method="POST">
                                @csrf
                                Feedback : <br>
                                <textarea style="width:100%;height:130px;" name="feedback"></textarea><br>
                                Latest Score : <input type="number" name="score"
                                    value="{{ $existing?->student_score }}" min="0" max="20" />
                                <button type="submit" class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Submit
                                    Feedback
                                </button>
                            </form>
                        @elseif ($submittedCode->status == Answer::STATUS_3 && Auth::user()->role == 'lecturer')
                            Lecturer Feedback : <br><br>
                            Latest Score : {{ $existing?->student_score }}
                        @endif



                        @endif

                    
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
