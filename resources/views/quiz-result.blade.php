<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} — Results</title>
    @vite(['resources/css/app.css', 'resources/css/pages/quiz-result-page.css', 'resources/js/app.js'])
    
</head>
<body>
<x-quiz-nav />

<div class="page" id="quizResultPage" data-percentage="{{ $percentage }}">
    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <img
                src="{{ $topic->image ? \Illuminate\Support\Facades\Storage::url($topic->image) : asset('images/appicon.jpg') }}"
                alt="{{ $topic->name }} icon"
                class="topic-icon"
            >
            <h1>Quiz complete!</h1>
            <div class="topic-name">{{ $topic->name }}</div>
        </div>

        {{-- Score ring + text --}}
        <div class="score-ring-wrap">
            <div class="ring-container">
                <svg class="ring-svg" viewBox="0 0 150 150">
                    <circle class="ring-bg" cx="75" cy="75" r="65"/>
                    <circle class="ring-fill" id="ringFill" cx="75" cy="75" r="65"
                            stroke="url(#ringGrad)"/>
                    <defs>
                        <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            @if($percentage >= 70)
                                <stop offset="0%"   stop-color="#40e090"/>
                                <stop offset="100%" stop-color="#20c060"/>
                            @elseif($percentage >= 50)
                                <stop offset="0%"   stop-color="#60b4ff"/>
                                <stop offset="100%" stop-color="#2080e0"/>
                            @elseif($percentage >= 30)
                                <stop offset="0%"   stop-color="#ffc840"/>
                                <stop offset="100%" stop-color="#e09020"/>
                            @else
                                <stop offset="0%"   stop-color="#ff6450"/>
                                <stop offset="100%" stop-color="#e03020"/>
                            @endif
                        </linearGradient>
                    </defs>
                </svg>
                <div class="ring-center">
                    <div class="ring-pct" id="pctCount">0<span class="ring-pct-sym">%</span></div>
                </div>
            </div>

            <div class="result-name">
                <strong>{{ Auth::user()->name }}</strong>, you scored
            </div>
            <div class="result-score">
                {{ $score }} <span>/ {{ $total }}</span>
            </div>
            <div class="result-message">{{ $message }}</div>
        </div>

        {{-- Score bar --}}
        <div class="score-bar-wrap">
            <div class="score-bar-track">
                <div class="score-bar-fill {{ $percentage >= 70 ? 'bar-great' : ($percentage >= 50 ? 'bar-good' : ($percentage >= 30 ? 'bar-ok' : 'bar-low')) }}"
                     id="scoreBar">
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="btn-group">
            <a href="{{ route('quiz.show', $topic->slug) }}" class="btn btn-retake">
                Retake quiz
            </a>
            <a href="{{ route('quizes') }}" class="btn btn-topics">
                Choose another topic
            </a>
        </div>

        {{-- Leaderboard link --}}
        <div class="lb-teaser">
            <a href="{{ route('leaderboard') }}">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 20V10M12 20V4M6 20v-6"/>
                </svg>
                View leaderboard
            </a>
        </div>

    </div>
</div>


</body>
</html>
