<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
                'image' => $t->image ? Storage::url($t->image) : null,
                'qs'    => $t->questions_count,
                'url'   => route('quiz.show', $t->slug),
            ];
        })->values();

        return view('quizes', compact('topics', 'topicsJson'));
    }

    public function leaderboard()
    {
        $scores = QuizAttempt::with(['user', 'topic'])
            ->where('total_questions', '>', 0)
            ->get()
            ->groupBy(fn ($attempt) => $attempt->user_id . ':' . $attempt->topic_id)
            ->map(function ($attempts) {
                return $attempts
                    ->sort(fn ($a, $b) => [
                        $b->score / $b->total_questions,
                        $b->score,
                        $b->total_questions,
                        $b->created_at?->timestamp ?? 0,
                    ] <=> [
                        $a->score / $a->total_questions,
                        $a->score,
                        $a->total_questions,
                        $a->created_at?->timestamp ?? 0,
                    ])
                    ->first();
            })
            ->sort(fn ($a, $b) => [
                $b->score / $b->total_questions,
                $b->score,
                $b->total_questions,
                $b->created_at?->timestamp ?? 0,
            ] <=> [
                $a->score / $a->total_questions,
                $a->score,
                $a->total_questions,
                $a->created_at?->timestamp ?? 0,
            ])
            ->values()
            ->take(50);

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
