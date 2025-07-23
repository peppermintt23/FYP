<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Answer;
use App\Models\Exercise;

class CppCompilerController extends Controller
{
    public function runCpp(Request $request)
    {
        $code = $request->input('code');
        $stdin = $request->input('stdin', '');
        $exercise_id = $request->input('exercise_id');

        if (empty($code)) {
            return back()->with([
                'compiler_status' => 'No code submitted',
                'compiler_output' => '',
                'old_code' => '',
                'old_stdin' => ''
            ]);
        }

        // Prepare payload for Judge0 (no base64 encoding)
        $payload = [
            'language_id' => 54,
            'source_code' => $code,
            'stdin' => $stdin
        ];

        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Key' => 'caae9abdadmsh481835e401a2e35p1e1c59jsn12472d0cfd2e',
                'X-RapidAPI-Host' => 'judge0-ce.p.rapidapi.com',
                'Content-Type' => 'application/json'
            ])->post('https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=false&wait=true', $payload);

            $result = $response->json();

            $output = $result['stdout'] ?? $result['compile_output'] ?? $result['message'] ?? 'No output';
            $status = $result['status']['description'] ?? 'Unknown';

            $exercise_id = (int) $request->input('exercise_id');
            if (!$exercise_id || !is_numeric($exercise_id)) {
                return back()->with('error', 'Invalid exercise ID.');
            }

            $exercise = Exercise::find($exercise_id);
            if (!$exercise) {
                return back()->with('error', 'Exercise not found.');
            }

            // Decide the score
            $expectedOutput = trim($exercise->expected_output);
            $actualOutput = trim($output);

            $student_score = ($expectedOutput === $actualOutput) ? 20 : 10;

            $cmp = 'Need-Compiler';
            $existing = Answer::where('student_id', auth()->id())
                ->where('exercise_id', $exercise_id)
                ->where('category', $cmp)
                ->where('step_number', 100) // special marker
                ->first();  

            if (!$existing) {
                Answer::create([
                    'exercise_id' => $exercise_id,
                    'student_id' => auth()->id(),
                    'step_number' => 100,
                    'answer' => $code,
                    'parent_answer_id' => 0,
                    'category' => $cmp,
                    'compiler_output' => $output,
                    'student_score' => $student_score
                ]);
            } else {
                $existing->update([
                    'answer' => $code,
                    'compiler_output' => $output,
                    'student_score' => $student_score
                ]);
            }

            return redirect()->route('answer.show', ['exercise' => $exercise_id])
                ->with([
                    'compiler_status' => $status,
                    'compiler_output' => $output,
                    'old_code' => $code,
                    'old_stdin' => $stdin
                ]);

        } catch (\Exception $e) {
            return back()->with([
                'compiler_status' => 'Error',
                'compiler_output' => $e->getMessage(),
                'old_code' => $code,
                'old_stdin' => $stdin
            ]);
        }
    }
}
