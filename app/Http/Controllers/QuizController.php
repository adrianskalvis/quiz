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
        // Randomize question order, eager load answers
        $questions = $topic->questions()
            ->with('answers')
            ->get()
            ->shuffle()
            ->map(function ($q) {
                // Randomize answer order too
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

        return redirect()->route('quiz.result', [
            'topic' => $topic->slug,
            'score' => $score,
            'total' => $questions->count(),
        ]);
    }

    public function result(Request $request, Topic $topic)
    {
        return view('quiz-result', [
            'topic' => $topic,
            'score' => $request->query('score', 0),
            'total' => $request->query('total', 0),
        ]);
    }

}
