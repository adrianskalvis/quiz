<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Scores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .screen {
            width: 100%; min-height: 100vh; position: relative;
            background: url('/images/welcomebg.jpg') center/cover no-repeat fixed;
        }

        /* ── Aero Nav Buttons ── */
        .aero-btn {
            position: relative;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Instrument Sans', sans-serif;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 1px 2px rgba(0,0,0,0.35);
            border: 1px solid rgba(255,255,255,0.55);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.55) 0%, rgba(255,255,255,0.15) 48%, rgba(100,200,255,0.25) 50%, rgba(60,160,255,0.45) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.7) 0%, rgba(30,120,230,0.85) 100%);
            box-shadow: 0 2px 8px rgba(0,100,255,0.35), 0 1px 0 rgba(255,255,255,0.6) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            overflow: hidden;
            display: inline-block;
            cursor: pointer;
        }
        .aero-btn::before {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.75) 0%, rgba(255,255,255,0.1) 100%);
            pointer-events: none;
        }
        .aero-btn:hover {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.65) 0%, rgba(255,255,255,0.2) 48%, rgba(120,215,255,0.3) 50%, rgba(80,180,255,0.55) 100%),
                linear-gradient(180deg, rgba(100,190,255,0.8) 0%, rgba(40,140,255,0.9) 100%);
            box-shadow: 0 4px 16px rgba(0,120,255,0.5), 0 1px 0 rgba(255,255,255,0.7) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            transform: translateY(-1px);
        }
        .aero-btn:active {
            transform: translateY(0px);
            box-shadow: 0 1px 4px rgba(0,100,255,0.3), 0 1px 0 rgba(255,255,255,0.5) inset;
        }

        .aero-btn-ghost {
            position: relative;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Instrument Sans', sans-serif;
            color: rgba(255,255,255,0.95);
            letter-spacing: 0.02em;
            border: 1px solid rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.14);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            display: inline-block;
            cursor: pointer;
            overflow: hidden;
        }
        .aero-btn-ghost::before {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }
        .aero-btn-ghost:hover {
            background: rgba(255,255,255,0.24);
            border-color: rgba(255,255,255,0.6);
            color: #fff;
            transform: translateY(-1px);
        }
        .aero-btn-ghost:active { transform: translateY(0); }

        /* ── Top bar ── */
        .topbar {
            position: sticky; top: 0; left: 0; right: 0; z-index: 20;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 28px;
            background: linear-gradient(180deg, rgba(190,215,238,0.22) 0%, rgba(165,198,225,0.13) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 1px 0 rgba(255,255,255,0.4) inset;
        }

        .hello {
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            text-shadow: 0 1px 6px rgba(0,0,0,0.9), 0 0 20px rgba(0,0,0,0.7);
        }
        .hello strong { color: #fff; }
        .nav { display: flex; gap: 8px; align-items: center; }

        /* ── Content ── */
        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
        }

        .card {
            width: 100%;
            max-width: 700px;
            background: rgba(8, 20, 40, 0.28);
            border: 0.5px solid rgba(255,255,255,0.15);
            border-radius: 24px;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            overflow: hidden;
        }
        .card::before {
            content: '';
            display: block;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
        }

        .card-header {
            padding: 28px 32px 20px;
            border-bottom: 0.5px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: space-between;
        }
        .header-left { display: flex; align-items: center; gap: 14px; }
        .header-icon { font-size: 32px; }
        .card-header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 300;
            letter-spacing: -0.5px;
            text-shadow: 0 0 50px rgba(140,210,255,0.65), 0 2px 12px rgba(0,0,0,0.9), 0 0 40px rgba(0,0,0,0.6);
        }
        .card-header p { color: rgba(255,255,255,0.65); font-size: 12px; margin-top: 2px; }

        /* ── Stats row ── */
        .stats-row {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 1px; background: rgba(255,255,255,0.08);
            border-bottom: 0.5px solid rgba(255,255,255,0.08);
        }
        .stat-box { padding: 18px 20px; background: rgba(255,255,255,0.03); text-align: center; }
        .stat-value {
            color: #fff; font-size: 24px; font-weight: 300;
            text-shadow: 0 0 50px rgba(140,210,255,0.65), 0 2px 12px rgba(0,0,0,0.9);
        }
        .stat-label { color: rgba(255,255,255,0.6); font-size: 11px; margin-top: 2px; }

        /* ── Attempts list ── */
        .attempts-list { padding: 8px 0; }
        .attempt-row {
            display: flex; align-items: center; gap: 16px;
            padding: 14px 24px;
            border-bottom: 0.5px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .attempt-row:last-child { border-bottom: none; }
        .attempt-row:hover { background: rgba(255,255,255,0.04); }

        .attempt-icon {
            font-size: 24px; flex-shrink: 0;
            filter: drop-shadow(0 0 6px rgba(140,210,255,0.3));
        }
        .attempt-info { flex: 1; min-width: 0; }
        .attempt-topic { color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 500; }
        .attempt-date { color: rgba(255,255,255,0.6); font-size: 11px; margin-top: 2px; }

        .attempt-score-wrap { display: flex; flex-direction: column; align-items: flex-end; gap: 5px; flex-shrink: 0; }
        .attempt-score { color: #fff; font-size: 15px; font-weight: 500; }
        .attempt-score span { color: rgba(255,255,255,0.65); font-weight: 400; font-size: 13px; }

        .mini-bar {
            width: 80px; height: 6px;
            background: rgba(0,0,0,0.25);
            border-radius: 99px;
            border: 0.5px solid rgba(255,255,255,0.08);
            overflow: hidden;
        }
        .mini-bar-fill { height: 100%; border-radius: 99px; position: relative; }
        .mini-bar-fill::after {
            content: '';
            position: absolute; top: 0; left: 2px; right: 2px; height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.5) 0%, transparent 100%);
            border-radius: 99px;
        }
        .bar-great { background: linear-gradient(90deg, rgba(40,180,90,0.9), rgba(80,220,130,0.9)); box-shadow: 0 0 6px rgba(40,180,90,0.5); }
        .bar-good  { background: linear-gradient(90deg, rgba(40,130,230,0.9), rgba(80,180,255,0.9)); box-shadow: 0 0 6px rgba(40,130,230,0.5); }
        .bar-ok    { background: linear-gradient(90deg, rgba(200,140,20,0.9), rgba(255,190,60,0.9));  box-shadow: 0 0 6px rgba(200,140,20,0.5); }
        .bar-low   { background: linear-gradient(90deg, rgba(200,50,30,0.9), rgba(255,90,70,0.9));   box-shadow: 0 0 6px rgba(200,50,30,0.5); }

        .pct-badge { font-size: 10px; padding: 2px 7px; border-radius: 99px; font-weight: 600; }
        .badge-great { background: rgba(40,180,90,0.2);  color: rgba(80,220,130,0.9);  border: 0.5px solid rgba(40,180,90,0.3); }
        .badge-good  { background: rgba(40,130,230,0.2); color: rgba(100,190,255,0.9); border: 0.5px solid rgba(40,130,230,0.3); }
        .badge-ok    { background: rgba(200,140,20,0.2); color: rgba(255,190,60,0.9);  border: 0.5px solid rgba(200,140,20,0.3); }
        .badge-low   { background: rgba(200,50,30,0.2);  color: rgba(255,100,80,0.9);  border: 0.5px solid rgba(200,50,30,0.3); }

        /* Retake — mini ghost pill */
        .retake-btn {
            position: relative;
            font-size: 11px; padding: 0.35rem 0.9rem;
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.14);
            backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
            color: rgba(255,255,255,0.9);
            font-family: 'Instrument Sans', sans-serif; font-weight: 600;
            text-decoration: none; text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            transition: all 0.15s ease; flex-shrink: 0; overflow: hidden;
            display: inline-block;
        }
        .retake-btn::before {
            content: '';
            position: absolute; top: 0; left: 5%; right: 5%; height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }
        .retake-btn:hover {
            background: rgba(255,255,255,0.24);
            border-color: rgba(255,255,255,0.6);
            color: #fff; transform: translateY(-1px);
        }
        .retake-btn:active { transform: translateY(0); }

        /* ── Empty state ── */
        .empty { padding: 56px 32px; text-align: center; }
        .empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.7; }
        .empty-text {
            color: rgba(255,255,255,0.65); font-size: 13px; margin-bottom: 20px;
            text-shadow: 0 1px 6px rgba(0,0,0,0.8);
        }
        .empty-btn {
            position: relative;
            display: inline-block; padding: 0.45rem 1.4rem;
            border-radius: 2rem;
            font-size: 0.8rem; font-weight: 600; font-family: 'Instrument Sans', sans-serif;
            color: #fff; text-decoration: none; letter-spacing: 0.02em;
            text-shadow: 0 1px 2px rgba(0,0,0,0.35);
            border: 1px solid rgba(255,255,255,0.55);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.55) 0%, rgba(255,255,255,0.15) 48%, rgba(100,200,255,0.25) 50%, rgba(60,160,255,0.45) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.7) 0%, rgba(30,120,230,0.85) 100%);
            box-shadow: 0 2px 8px rgba(0,100,255,0.35), 0 1px 0 rgba(255,255,255,0.6) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            backdrop-filter: blur(6px); overflow: hidden; transition: all 0.15s ease;
        }
        .empty-btn::before {
            content: '';
            position: absolute; top: 0; left: 5%; right: 5%; height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.75) 0%, rgba(255,255,255,0.1) 100%);
            pointer-events: none;
        }
        .empty-btn:hover {
            box-shadow: 0 4px 16px rgba(0,120,255,0.5), 0 1px 0 rgba(255,255,255,0.7) inset;
            transform: translateY(-1px);
        }
        .empty-btn:active { transform: translateY(0); }
    </style>
</head>
<body>
<div class="screen">

    <div class="topbar">
        <div class="hello">Hello, <strong>{{ Auth::user()->name }}</strong></div>
        <div></div>
        <nav class="nav">
            @if(Auth::user()->is_admin ?? false)
                <a href="{{ route('admin.dashboard') }}" class="aero-btn" style="
                    background:
                        linear-gradient(180deg,rgba(255,255,255,0.5) 0%,rgba(255,255,255,0.12) 48%,rgba(255,200,60,0.3) 50%,rgba(220,160,0,0.55) 100%),
                        linear-gradient(180deg,rgba(255,200,80,0.75) 0%,rgba(200,140,0,0.9) 100%);
                    box-shadow:0 2px 8px rgba(200,140,0,0.4),0 1px 0 rgba(255,255,255,0.6) inset;
                ">Admin</a>
            @endif
            <a href="{{ route('quizes') }}" class="aero-btn-ghost">Quizzes</a>
            <a href="{{ route('leaderboard') }}" class="aero-btn-ghost">Leaderboard</a>
            <a href="{{ route('scores') }}" class="aero-btn-ghost">My scores</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="aero-btn-ghost">Log out</button>
            </form>
        </nav>
    </div>

    <div class="content">
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

                <div class="attempts-list">
                    @foreach($attempts as $attempt)
                        @php
                            $pct  = $attempt->total_questions > 0
                                ? round($attempt->score / $attempt->total_questions * 100) : 0;
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

                            <a href="{{ route('quiz.show', $attempt->topic->slug) }}" class="retake-btn">Retake</a>
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

</div>
</body>
</html>