<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    @vite(['resources/css/app.css', 'resources/css/pages/leaderboard-page.css', 'resources/js/app.js'])

    
</head>

<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        <div class="card-header">
            <div class="header-icon">
                <img src="{{ asset('images/search.jpg') }}" alt="Global Search" width="50" height="50">
            </div>
            <div>
                <h1>Leaderboard</h1>
                <p>Top {{ $scores->count() }} scores across all topics</p>
            </div>
        </div>

        @if($scores->count() > 0)

            @php
                $first  = $scores->get(0);
                $second = $scores->get(1);
                $third  = $scores->get(2);
            @endphp

            <div class="podium">

                @if($second)
                    <div class="podium-item podium-2">
                        <div class="podium-avatar">{{ strtoupper(substr($second->user->name,0,1)) }}</div>
                        <div class="podium-name">{{ $second->user->name }}</div>
                        <div class="podium-score">{{ $second->score }}/{{ $second->total_questions }}</div>
                        <div class="podium-block">
                            <svg class="medal" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="silver" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#e6fbff"/>
                                        <stop offset="100%" stop-color="#6fbbe6"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="12" cy="12" r="10" fill="url(#silver)" stroke="rgba(255,255,255,0.5)"/>
                                <circle cx="12" cy="12" r="6" fill="rgba(255,255,255,0.25)"/>
                                <text x="12" y="16" text-anchor="middle" font-size="10" fill="#fff">2</text>
                            </svg>
                        </div>
                    </div>
                @endif

                @if($first)
                    <div class="podium-item podium-1">
                        <div class="podium-avatar">{{ strtoupper(substr($first->user->name,0,1)) }}</div>
                        <div class="podium-name">{{ $first->user->name }}</div>
                        <div class="podium-score">{{ $first->score }}/{{ $first->total_questions }}</div>
                        <div class="podium-block">
                            <svg class="medal" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="gold" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#fff2b3"/>
                                        <stop offset="50%" stop-color="#ffd36b"/>
                                        <stop offset="100%" stop-color="#8fd3ff"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="12" cy="12" r="10" fill="url(#gold)" stroke="rgba(255,255,255,0.5)"/>
                                <circle cx="12" cy="12" r="6" fill="rgba(255,255,255,0.2)"/>
                                <text x="12" y="16" text-anchor="middle" font-size="10" fill="#fff">1</text>
                            </svg>
                        </div>
                    </div>
                @endif

                @if($third)
                    <div class="podium-item podium-3">
                        <div class="podium-avatar">{{ strtoupper(substr($third->user->name,0,1)) }}</div>
                        <div class="podium-name">{{ $third->user->name }}</div>
                        <div class="podium-score">{{ $third->score }}/{{ $third->total_questions }}</div>
                        <div class="podium-block">
                            <svg class="medal" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="bronze" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#d8fff2"/>
                                        <stop offset="100%" stop-color="#3bbf9a"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="12" cy="12" r="10" fill="url(#bronze)" stroke="rgba(255,255,255,0.5)"/>
                                <circle cx="12" cy="12" r="6" fill="rgba(255,255,255,0.2)"/>
                                <text x="12" y="16" text-anchor="middle" font-size="10" fill="#fff">3</text>
                            </svg>
                        </div>
                    </div>
                @endif

            </div>

            <table class="lb-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Player</th>
                    <th>Topic</th>
                    <th>Score</th>
                </tr>
                </thead>

                <tbody>
                @foreach($scores as $i => $attempt)
                    @php
                        $isMe = $attempt->user_id === Auth::id();
                        $pct = $attempt->total_questions > 0
                            ? round($attempt->score / $attempt->total_questions * 100)
                            : 0;
                    @endphp

                    <tr class="{{ $isMe ? 'is-me' : '' }}">
                        <td class="rank-cell">
                            @if($i === 0)
                                <span class="medal">🥇</span>
                            @elseif($i === 1)
                                <span class="medal">🥈</span>
                            @elseif($i === 2)
                                <span class="medal">🥉</span>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </td>

                        <td>
                            <div class="user-cell">
                                <div class="user-initial">{{ strtoupper(substr($attempt->user->name,0,1)) }}</div>
                                {{ $attempt->user->name }}
                                @if($isMe)<span class="me-badge">you</span>@endif
                            </div>
                        </td>

                        <td>
                        <span class="topic-pill">
                            <img
                                src="{{ $attempt->topic->image ? \Illuminate\Support\Facades\Storage::url($attempt->topic->image) : asset('images/appicon.jpg') }}"
                                alt="{{ $attempt->topic->name }} icon"
                                class="topic-pill-icon"
                            >
                            {{ $attempt->topic->name }}
                        </span>
                        </td>

                        <td>
                            <div class="mini-bar-wrap">
                                <span class="score-cell">{{ $attempt->score }}/{{ $attempt->total_questions }}</span>
                                <div class="mini-bar">
                                    <div class="mini-bar-fill" data-width="{{ $pct }}"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else
            <div class="empty">No scores yet — be the first to complete a quiz!</div>
        @endif

    </div>
</div>

</body>
</html>
