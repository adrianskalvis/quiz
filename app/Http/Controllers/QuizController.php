<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $topics = Topic::withCount('questions')
            ->where('is_active', true)
            ->get();

        $topicsJson = $topics->map(function ($t) {
            return [
                'slug'  => $t->slug,
                'label' => $t->name,
                'image' => $t->image ? Storage::url($t->image) : asset('images/appicon.jpg'),
                'qs'    => $t->questions_count,
                'url'   => route('quiz.show', $t->slug),
            ];
        })->values();

        return view('quiz', compact('topic', 'questions', 'topicsJson'));
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

        $attempt = QuizAttempt::create([
            'user_id'         => Auth::id(),
            'topic_id'        => $topic->id,
            'score'           => $score,
            'total_questions' => $questions->count(),
        ]);

        return redirect()->route('quiz.result', ['topic' => $topic->slug])
            ->with('attempt_id', $attempt->id);
    }

    public function result(Topic $topic)
    {
        $attempt = QuizAttempt::query()
            ->where('user_id', Auth::id())
            ->where('topic_id', $topic->id)
            ->when(session('attempt_id'), fn ($query, $attemptId) => $query->whereKey($attemptId))
            ->latest()
            ->first();

        if (! $attempt && session('attempt_id')) {
            $attempt = QuizAttempt::query()
                ->where('user_id', Auth::id())
                ->where('topic_id', $topic->id)
                ->latest()
                ->first();
        }

        $score      = (int) ($attempt?->score ?? 0);
        $total      = (int) ($attempt?->total_questions ?? $topic->questions()->count());
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
