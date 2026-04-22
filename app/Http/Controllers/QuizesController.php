<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;

class QuizesController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('questions')
            ->where('is_active', true)
            ->get();

        $topicsJson = $topics->map(function ($t) {
            return [
                'slug'  => $t->slug,
                'label' => $t->name,
                'icon'  => $t->icon ?? '📝',
                'qs'    => $t->questions_count,
                'url'   => route('quiz.show', $t->slug),
            ];
        })->values();

        return view('quizes', compact('topics', 'topicsJson'));
    }

    public function leaderboard()
    {
        $scores = QuizAttempt::with(['user', 'topic'])
            ->orderByDesc('score')
            ->orderBy('created_at')
            ->take(50)
            ->get();

        return view('leaderboard', compact('scores'));
    }

    public function scores()
    {
        $attempts = QuizAttempt::with('topic')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('scores', compact('attempts'));
    }
}
