<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Scores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: sans-serif;
            min-height: 100vh;
            background: url('/images/welcomebg.jpg') center/cover no-repeat fixed;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: rgba(5, 18, 32, 0.55);
            z-index: 0;
        }

        .page {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 100px 20px 60px;
        }

        .card {
            width: 100%;
            max-width: 700px;
            background: rgba(255,255,255,0.07);
            border: 0.5px solid rgba(255,255,255,0.15);
            border-radius: 24px;
            backdrop-filter: blur(24px);
            overflow: hidden;
        }
        .card::before {
            content: '';
            display: block;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
        }

        /* ── Header ── */
        .card-header {
            padding: 28px 32px 20px;
            border-bottom: 0.5px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-left { display: flex; align-items: center; gap: 14px; }
        .header-icon { font-size: 32px; }
        .card-header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 500;
            letter-spacing: -0.3px;
            text-shadow: 0 0 40px rgba(140,210,255,0.4);
        }
        .card-header p {
            color: rgba(255,255,255,0.4);
            font-size: 12px;
            margin-top: 2px;
        }

        /* ── Stats row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: rgba(255,255,255,0.08);
            border-bottom: 0.5px solid rgba(255,255,255,0.08);
        }
        .stat-box {
            padding: 18px 20px;
            background: rgba(255,255,255,0.03);
            text-align: center;
        }
        .stat-value {
            color: #fff;
            font-size: 24px;
            font-weight: 500;
            text-shadow: 0 0 20px rgba(140,210,255,0.4);
        }
        .stat-label {
            color: rgba(255,255,255,0.35);
            font-size: 11px;
            margin-top: 2px;
        }

        /* ── Attempts list ── */
        .attempts-list {
            padding: 8px 0;
        }
        .attempt-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 24px;
            border-bottom: 0.5px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .attempt-row:last-child { border-bottom: none; }
        .attempt-row:hover { background: rgba(255,255,255,0.04); }

        .attempt-icon {
            font-size: 24px;
            flex-shrink: 0;
            filter: drop-shadow(0 0 6px rgba(140,210,255,0.3));
        }

        .attempt-info { flex: 1; min-width: 0; }
        .attempt-topic {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            font-weight: 500;
        }
        .attempt-date {
            color: rgba(255,255,255,0.35);
            font-size: 11px;
            margin-top: 2px;
        }

        .attempt-score-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
            flex-shrink: 0;
        }
        .attempt-score {
            color: #fff;
            font-size: 15px;
            font-weight: 500;
        }
        .attempt-score span {
            color: rgba(255,255,255,0.4);
            font-weight: 400;
            font-size: 13px;
        }

        /* Mini aero bar */
        .mini-bar {
            width: 80px; height: 6px;
            background: rgba(0,0,0,0.25);
            border-radius: 99px;
            border: 0.5px solid rgba(255,255,255,0.08);
            overflow: hidden;
        }
        .mini-bar-fill {
            height: 100%;
            border-radius: 99px;
            position: relative;
        }
        .mini-bar-fill::after {
            content: '';
            position: absolute;
            top: 0; left: 2px; right: 2px;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.5) 0%, transparent 100%);
            border-radius: 99px;
        }
        .bar-great {
            background: linear-gradient(90deg, rgba(40,180,90,0.9), rgba(80,220,130,0.9));
            box-shadow: 0 0 6px rgba(40,180,90,0.5);
        }
        .bar-good {
            background: linear-gradient(90deg, rgba(40,130,230,0.9), rgba(80,180,255,0.9));
            box-shadow: 0 0 6px rgba(40,130,230,0.5);
        }
        .bar-ok {
            background: linear-gradient(90deg, rgba(200,140,20,0.9), rgba(255,190,60,0.9));
            box-shadow: 0 0 6px rgba(200,140,20,0.5);
        }
        .bar-low {
            background: linear-gradient(90deg, rgba(200,50,30,0.9), rgba(255,90,70,0.9));
            box-shadow: 0 0 6px rgba(200,50,30,0.5);
        }

        .pct-badge {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 99px;
            font-weight: 500;
        }
        .badge-great { background: rgba(40,180,90,0.2);  color: rgba(80,220,130,0.9);  border: 0.5px solid rgba(40,180,90,0.3); }
        .badge-good  { background: rgba(40,130,230,0.2); color: rgba(100,190,255,0.9); border: 0.5px solid rgba(40,130,230,0.3); }
        .badge-ok    { background: rgba(200,140,20,0.2); color: rgba(255,190,60,0.9);  border: 0.5px solid rgba(200,140,20,0.3); }
        .badge-low   { background: rgba(200,50,30,0.2);  color: rgba(255,100,80,0.9);  border: 0.5px solid rgba(200,50,30,0.3); }

        .retake-btn {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 10px;
            border: 0.5px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .retake-btn:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }

        /* Empty state */
        .empty {
            padding: 56px 32px;
            text-align: center;
        }
        .empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.4; }
        .empty-text { color: rgba(255,255,255,0.3); font-size: 14px; margin-bottom: 20px; }
        .empty-btn {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 13px;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(180deg,
            rgba(100,190,255,0.9) 0%,
            rgba(40,130,230,1)   40%,
            rgba(20,100,210,1)   60%,
            rgba(60,150,255,0.9) 100%
            );
            box-shadow: 0 0 0 1px rgba(120,200,255,0.3), 0 4px 16px rgba(40,120,220,0.3);
            transition: all 0.2s;
        }
        .empty-btn:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        <div class="card-header">
            <div class="header-left">
                <div class="header-icon">📊</div>
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
                        <div class="attempt-icon">{{ $attempt->topic->icon ?? '📝' }}</div>

                        <div class="attempt-info">
                            <div class="attempt-topic">{{ $attempt->topic->name }}</div>
                            <div class="attempt-date">{{ $attempt->created_at->diffForHumans() }}</div>
                        </div>

                        <div class="attempt-score-wrap">
                            <div class="attempt-score">
                                {{ $attempt->score }} <span>/ {{ $attempt->total_questions }}</span>
                            </div>
                            <div class="mini-bar">
                                <div class="mini-bar-fill bar-{{ $tier }}" style="width:{{ $pct }}%"></div>
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
                <div class="empty-icon">🎯</div>
                <div class="empty-text">No quizzes taken yet — start one!</div>
                <a href="{{ route('quizes') }}" class="empty-btn">Browse topics</a>
            </div>
        @endif

    </div>
</div>
</body>
</html>
