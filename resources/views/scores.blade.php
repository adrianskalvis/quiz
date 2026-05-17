<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Scores</title>
    @vite(['resources/css/app.css', 'resources/css/pages/scores-page.css', 'resources/js/app.js'])
    
</head>
<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        <div class="card-header">
            <div class="header-left">
                <div class="header-icon">
                    <img src="{{ asset('images/profilebe.jpg') }}" alt="Profile Icon" width="60" height="60">
                </div>
                <div>
                    <h1>My scores</h1>
                    <p>{{ Auth::user()->name }}'s quiz history</p>
                </div>
            </div>
        </div>

        @if($attempts->count() > 0)
            @php
                $totalAttempts = $attempts->count();
                $avgPct = round($attempts->avg(fn($a) =>
                    $a->total_questions > 0 ? ($a->score / $a->total_questions * 100) : 0
                ));
                $bestScore = $attempts->max('score');
            @endphp

            {{-- Stats row --}}
            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-value">{{ $totalAttempts }}</div>
                    <div class="stat-label">Quizzes taken</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $avgPct }}%</div>
                    <div class="stat-label">Average score</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $bestScore }}</div>
                    <div class="stat-label">Best score</div>
                </div>
            </div>

            {{-- Attempts --}}
            <div class="attempts-list">
                @foreach($attempts as $attempt)
                    @php
                        $pct = $attempt->total_questions > 0
                            ? round($attempt->score / $attempt->total_questions * 100)
                            : 0;
                        $tier = $pct >= 70 ? 'great' : ($pct >= 50 ? 'good' : ($pct >= 30 ? 'ok' : 'low'));
                    @endphp
                    <div class="attempt-row">
                        <img
                            src="{{ $attempt->topic->image ? \Illuminate\Support\Facades\Storage::url($attempt->topic->image) : asset('images/appicon.jpg') }}"
                            alt="{{ $attempt->topic->name }} icon"
                            class="attempt-icon"
                        >

                        <div class="attempt-info">
                            <div class="attempt-topic">{{ $attempt->topic->name }}</div>
                            <div class="attempt-date">{{ $attempt->created_at->diffForHumans() }}</div>
                        </div>

                        <div class="attempt-score-wrap">
                            <div class="attempt-score">
                                {{ $attempt->score }} <span>/ {{ $attempt->total_questions }}</span>
                            </div>
                            <div class="mini-bar">
                                <div class="mini-bar-fill bar-{{ $tier }}" data-width="{{ $pct }}"></div>
                            </div>
                        </div>

                        <span class="pct-badge badge-{{ $tier }}">{{ $pct }}%</span>

                        <a href="{{ route('quiz.show', $attempt->topic->slug) }}" class="retake-btn">
                            Retake
                        </a>
                    </div>
                @endforeach
            </div>

        @else
            <div class="empty">
                <div class="empty-icon">
                    <img src="{{ asset('images/appicon.jpg') }}" alt="icon" width="120" height="120">
                </div>
                <div class="empty-text">No quizzes taken yet — start one!</div>
                <a href="{{ route('quizes') }}" class="empty-btn">Browse topics</a>
            </div>
        @endif

    </div>
</div>
</body>
</html>
