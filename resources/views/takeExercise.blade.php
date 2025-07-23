@php
    use App\Models\Answer;
@endphp
<x-app-layout>
    <div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
        <!-- Top Header/Profile Bar (Neon) -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200 z-50">
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
        </header>
        <!-- Sidebar (Neon, conditional by role) -->
        @if (Auth::check() && Auth::user()->role == 'student')
            <aside class="fixed left-0 top-0 h-screen w-64 text-white p-6 z-50">
                <div class="mb-8 flex items-center space-x-3">
                    <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                    <span class="text-2xl font-bold">CQPP</span>
                </div>
                <nav class="space-y-4 mt-8">
                    <a href="{{ route('student-dashboard') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 4l9 5.75M4.5 10.5V19a1.5 1.5 0 001.5 1.5h12a1.5 1.5 0 001.5-1.5v-8.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('notes.index') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <rect x="3" y="4" width="7" height="16" rx="2" ry="2" stroke-width="2" stroke="currentColor" fill="none"/>
                            <rect x="14" y="4" width="7" height="16" rx="2" ry="2" stroke-width="2" stroke="currentColor" fill="none"/>
                        </svg>
                        <span>Notes</span>
                    </a>
                    <a href="{{ route('answer.index') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6h6" />
                        </svg>
                        <span>Exercise</span>
                    </a>
                     <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button"
                            class="flex items-center w-full space-x-3 hover:bg-[#142755bb] p-2 rounded focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-7-9a7 7 0 0014 0V4H5v4z" />
                            </svg>
                            <span>Leaderboard</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 mt-1 w-48 bg-gray rounded shadow-lg z-30"
                            x-transition>
                            <a href="{{ url('/student/leaderboard/personal') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-t">
                                Personal Leaderboard
                            </a>
                            <a href="{{ url('/student/leaderboard/overall') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-b">
                                Overall Leaderboard
                            </a>
                        </div>

                    </div>
                </nav>
            </aside>
        @elseif(Auth::check() && Auth::user()->role == 'lecturer')
            <!-- Sidebar -->
            <aside class="fixed left-0 top-0 h-screen w-64 text-white p-6 z-50">
                <div class="mb-8 flex items-center space-x-3">
                    <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                    <span class="text-2xl font-bold">CQPP</span>
                </div>
                <nav class="space-y-4 mt-8">
                    <a href="{{ route('lecturer.dashboard') }}"
                        class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('manage.notes') }}"
                        class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span>Manage Learning Material</span>
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
                    <a href="report" class="flex items-center space-x-3 hover:bg-[#9158A1] p-2 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>Progress Report</span>
                    </a>
                </nav>
            </aside>
        @endif
        <!-- Main Content -->
        <main class="ml-55 mt-20 p-8 min-h-screen bg-transparent flex flex-col items-start justify-center">
            <!-- Stopwatch (UI Only) -->
                    <div id="stopwatch"
                        class="fixed top-20 right-6 flex items-center bg-[#050e1ae0] px-4 py-2 rounded-xl shadow-[0_0_12px_#15f7fc88] border border-[#13e2be] z-10"
                        style="font-family: 'Fira Mono', monospace; color: #19ffe7; font-size: 1.13rem; letter-spacing: 2px;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="#19ffe7" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="13" r="8" stroke="#19ffe7"/>
                            <path d="M12 9v4l3 2" stroke="#19ffe7" stroke-linecap="round"/>
                            <path d="M9 2h6" stroke="#19ffe7" stroke-linecap="round"/>
                        </svg>
                        <span id="timer">00:00:19</span>
                    </div>
            <div class="w-full max-w-4xl  p-8 mt-10 mx-auto">

                <!-- Question Section -->
                <div class="mb-6 bg-gray-700/80 rounded-lg shadow-lg p-8 relative">
                    <h2 class="text-2xl font-bold text-white mb-4">Exercise: {{ $exercise->exercise_title }}</h2>
                    <p class="mb-4  text-white"><strong>Question:</strong> {{ $exercise->question }}</p>
                </div>

                <div class="bg-gray-700/80 p-6 rounded-lg">
                    <b class="text-white">Expected output:
                        <span class="text-blue-300">{{ $exercise->expected_output }}</span>
                    </b>

                    <!-- Hint -->
                    <div class="mb-6 mt-4 text-white">
                        <strong class="text-lg">Hint:</strong>
                        @if ($exercise->hint)
                            <p class="text-blue-300">{{ $exercise->hint }}</p>
                        @else
                            <p class="text-blue-300">No hint available for this exercise.</p>
                        @endif
                    </div>
                    <!-- Submission or Feedback logic -->
                    --- {{ $submittedGuideline }}---
                    @if (!$existingAnswer && $exercise?->has_guideline == 'Yes')
                        <!-- Show Submission Form for Guideline Steps -->
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
                    @elseif ($existingAnswer?->status != Answer::STATUS_1 && $exercise?->has_guideline == 'No')
                        @if ($existingAnswer?->status != Answer::STATUS_2 && $existingAnswer?->status != Answer::STATUS_3)
                            <!-- Show code input for compiler-based question with no guideline -->
                            <form method="POST" action="{{ route('cpp.run') }}">
                                @csrf
                                
                                <input type="hidden" name="exercise_id" value="{{ $exercise->id }}" />

                                <label class="block mt-4 mb-2 font-semibold">Your Code:</label>
                                <textarea name="code" rows="10" class="w-full p-2 bg-white text-black rounded" required>
                                    {{ $existingAnswer?->answer }}
                                </textarea>

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
                                {{-- Score is probably not set until submission is finalized --}}
                            </p>
                            <form action="{{ route('answer.submitFinalExercise', $exercise->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="category" value="Need-Compiler" />
                                <button type="submit" class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Submit
                                    Answer</button>
                            </form>

                            {{-- lepas submit code --}}
                               @if ($submittedCode && $submittedCode->status == Answer::STATUS_2 && Auth::user()->role == 'lecturer')
                                    @if (session('success'))
                                        <div
                                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div
                                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('answer.giveFeedback') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="answer_id" value="{{ $submittedCode->id }}">
                                        Feedback : <br>
                                        <textarea style="width:100%;height:130px;" name="feedback" required></textarea><br>
                                        Latest Score :
                                        <input type="number" name="score"
                                            value="{{ $submittedCode->student_score ?? 0 }}" min="0"
                                            max="20" required />
                                        <button type="submit"
                                            class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Submit
                                            Feedback
                                        </button>
                                    </form>
                                @elseif($submittedFeedback && $submittedFeedback->status == Answer::STATUS_3)
                                    <div class="mb-2">
                                        <strong>Lecturer Feedback:</strong> {{ $submittedFeedback->feedback }}<br>
                                        <strong>Latest Score:</strong> {{ $submittedFeedback->student_score }}
                                    </div>
                                @endif


                        @endif
                    @endif


                    @if (
                        ($existingAnswer && $existingAnswer->status == Answer::PENDING_STATUS) ||
                            ($submittedGuideline && $submittedGuideline->status == Answer::STATUS_1) ||
                            ($submittedCode && $submittedCode->status == Answer::STATUS_2) ||
                            ($submittedFeedback && $submittedFeedback->status == Answer::STATUS_3))
                        <!-- Show Student Answer and Code Run if Needed -->

                        @if (Auth::check() && Auth::user()->role == 'student')
                        <p class="mt-2 font-semibold text-green-600">
                            ✅ You have already submitted this answer.
                        </p>

                        @elseif(Auth::check() && Auth::user()->role == 'lecturer')
                        <p class="mt-2 font-semibold text-green-600">
                            
                        </p>
                        @endif
                        <br>
                        <p class="text-white">Guidelines :</p>

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
                            <p class="mt-2"><strong>Compiler Status:</strong> {{ session('compiler_status') }}
                            </p>

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
                        @elseif(
                            ($submittedCode && $submittedCode->status == Answer::STATUS_2) ||
                                ($submittedFeedback && $submittedFeedback->status == Answer::STATUS_3))
                            <!-- Graded/Feedback view -->
                            @php
                                // $existing = \App\Models\Answer::where('student_id', $studentId)
                                //     ->where('exercise_id', $exercise->id)
                                //     ->where('category', 'Need-Compiler')
                                //     ->where('status', Answer::STATUS_2)
                                //     ->first();
                                // $studentCode = $existing?->answer ?? '';
                                $studentCode = $submittedCode?->answer ?? $submittedFeedback?->answer;
                            @endphp

                            <div class="mb-4 mt-2">
                                <strong class="block mb-1 text-white">Submitted Answer:</strong>
                                <pre class="bg-gray-200 p-4 rounded text-sm whitespace-pre-wrap">
                                {{ $studentCode }}
                                {}
                            </pre>
                            </div>

                            <p class="text-white mt-2 font-semibold">
                                Result #<span>Score : {{ $existing?->student_score ?? 0 }}/20</span>
                            </p>
                            <br>
                            @if ($submittedCode && $submittedCode->status == Answer::STATUS_2 && Auth::user()->role == 'lecturer')
                                @if (session('success'))
                                    <div
                                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('answer.giveFeedback') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="answer_id" value="{{ $submittedCode->id }}">
                                    <p class="text-white">Feedback:</p> <br>
                                    <textarea style="width:100%;height:130px;" name="feedback" required></textarea><br>
                                    <p class="text-white">Latest Score :</p>
                                    <input type="number" name="score"
                                        value="{{ $submittedCode->student_score ?? 0 }}" min="0"
                                        max="20" required />
                                    <button type="submit"
                                        class="mt-4 bg-blue-500 px-4 py-2 rounded text-white">Submit
                                        Feedback
                                    </button>
                                </form>
                            @elseif($submittedFeedback && $submittedFeedback->status == Answer::STATUS_3)
                                <div class="mb-2">
                                    <strong class="text-white">
                                        Lecturer Feedback:
                                    </strong>
                                    <strong class="text-blue-300"> {{ $submittedFeedback->feedback }} </strong> <br>

                                    <strong class="text-white">
                                        Latest Score:
                                    </strong> 
                                    <strong class="text-blue-300"> {{ $submittedFeedback->student_score }} </strong> <br>
                                  
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
    let timerInterval;
    let elapsed = 0;
    let running = false;

    function updateTimer() {
        let h = Math.floor(elapsed / 3600).toString().padStart(2, '0');
        let m = Math.floor((elapsed % 3600) / 60).toString().padStart(2, '0');
        let s = (elapsed % 60).toString().padStart(2, '0');
        document.getElementById('timer').textContent = `${h}:${m}:${s}`;
    }

    document.getElementById('startBtn').onclick = function() {
        if (!running) {
            running = true;
            timerInterval = setInterval(() => {
                elapsed++;
                updateTimer();
            }, 1000);
        }
    };
    document.getElementById('pauseBtn').onclick = function() {
        running = false;
        clearInterval(timerInterval);
    };
    document.getElementById('resetBtn').onclick = function() {
        running = false;
        clearInterval(timerInterval);
        elapsed = 0;
        updateTimer();
    };
    // Init display
    updateTimer();
</script>


<style>
    .neon-frame {
        background: rgba(10, 10, 30, 0.90);
        border: 3px solid #15f7fc;
        border-radius: 24px;
        box-shadow:
            0 0 18px 3px #15f7fc,
            0 0 38px 1px #00bfff85 inset,
            0 0 0 7px #061928;
        position: relative;
        overflow: hidden;
    }
    .neon-frame:before,
    .neon-frame:after {
        content: '';
        position: absolute;
        pointer-events: none;
        border-radius: inherit;
    }
    .neon-frame:before {
        inset: 0;
        border: 2px solid #19ffe7;
        filter: blur(3px);
        opacity: 0.55;
    }
    .neon-frame:after {
        inset: 8px;
        border: 2px solid #19ffe75c;
        filter: blur(7px);
        opacity: 0.3;
    }
    .neon-frame h2,
    .neon-frame h3,
    .neon-frame span,
    .neon-frame .text-white {
        color: #15f7fc !important;
        text-shadow: 0 0 12px #15f7fc99, 0 2px 14px #00284999;
        letter-spacing: 1.5px;
    }
    aside.fixed {
        background: linear-gradient(160deg, #0a132a 70%, #14e1ee3c 100%);
        border-right: 3.5px solid #13e2be;
        box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
    }
    aside.fixed .text-2xl {
        color: #13e2be !important;
        text-shadow: 0 0 8px #13e2be77;
    }
    aside.fixed nav a {
        background: transparent;
        border: 2px solid transparent;
        border-radius: 2px;
        color: #c9fbff;
        font-weight: 500;
        transition: all 0.18s;
        letter-spacing: 1.2px;
    }
    aside.fixed nav a:hover,
    aside.fixed nav a.active {
        background: #142755bb;
        border-color: #15f7fc;
        color: #15f7fc;
        box-shadow: 0 0 10px #15f7fc44;
    }
    header.fixed {
        background: #071c2d;
        box-shadow: 0 1px 10px #14e1ee33;
        color: #13e2be;
    }
    header .font-semibold {
        color: #15f7fc;
        text-shadow: 0 0 6px #15f7fcaa;
    }
    body, .min-h-screen {
        background: #050e1a;
    }
</style>
</x-app-layout>
