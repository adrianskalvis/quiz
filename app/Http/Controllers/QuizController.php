<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show(Topic $topic)
    {
        $questions = $topic->questions()
            ->with('answers')
            ->get()
            ->shuffle()
            ->map(function ($q) {
                $q->answers = $q->answers->shuffle()->values();
                return $q;
            })
            ->values();

        return view('quiz', compact('topic', 'questions'));
    }

    public function submit(Request $request, Topic $topic)
    {
        $questions = $topic->questions()->with('answers')->get();
        $score     = 0;

        foreach ($questions as $question) {
            $submitted = $request->input('answer_' . $question->id);
            $correct   = $question->answers->firstWhere('is_correct', true);
            if ($correct && (string)$submitted === (string)$correct->id) {
                $score++;
            }
        }

        QuizAttempt::create([
            'user_id'         => Auth::id(),
            'topic_id'        => $topic->id,
            'score'           => $score,
            'total_questions' => $questions->count(),
        ]);

        return redirect()->route('quiz.result', ['topic' => $topic->slug])
            ->with('score', $score)
            ->with('total', $questions->count());
    }

    public function result(Topic $topic)
    {
        $score      = (int) session('score', 0);
        $total      = (int) session('total', 0);
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

        $message = match(true) {
            $percentage >= 90 => 'Outstanding! You\'re a master!',
            $percentage >= 70 => 'Great job! Well done!',
            $percentage >= 50 => 'Not bad! Keep practicing!',
            $percentage >= 30 => 'Room to improve — try again!',
            default           => 'Don\'t give up, try again!',
        };

        return view('quiz-result', compact('topic', 'score', 'total', 'percentage', 'message'));
    }
}
