<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
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
            gap: 14px;
        }
        .header-icon {
            font-size: 32px;
            filter: drop-shadow(0 0 10px rgba(255,200,80,0.6));
        }
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

        /* ── Podium top 3 ── */
        .podium {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 12px;
            padding: 28px 32px 20px;
            border-bottom: 0.5px solid rgba(255,255,255,0.08);
        }
        .podium-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .podium-avatar {
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            color: #fff;
            font-size: 14px;
            border: 2px solid rgba(255,255,255,0.25);
            box-shadow: 0 4px 16px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .podium-name {
            color: rgba(255,255,255,0.85);
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            max-width: 80px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .podium-score {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
        }
        .podium-block {
            border-radius: 10px 10px 0 0;
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* 1st */
        .podium-1 .podium-avatar {
            width: 56px; height: 56px; font-size: 16px;
            background: radial-gradient(circle at 40% 35%, #ffe580, #f0a500);
            border-color: rgba(255,220,80,0.5);
            box-shadow: 0 0 20px rgba(255,200,50,0.4), inset 0 1px 0 rgba(255,255,255,0.4);
        }
        .podium-1 .podium-block {
            height: 80px;
            background: linear-gradient(180deg, rgba(255,210,60,0.3) 0%, rgba(200,150,20,0.2) 100%);
            border: 0.5px solid rgba(255,200,60,0.3);
        }
        /* 2nd */
        .podium-2 .podium-avatar {
            width: 46px; height: 46px;
            background: radial-gradient(circle at 40% 35%, #e8e8f0, #a0a8c0);
            border-color: rgba(200,210,230,0.4);
        }
        .podium-2 .podium-block {
            height: 56px;
            background: linear-gradient(180deg, rgba(180,190,220,0.2) 0%, rgba(140,150,180,0.15) 100%);
            border: 0.5px solid rgba(180,190,220,0.2);
        }
        /* 3rd */
        .podium-3 .podium-avatar {
            width: 40px; height: 40px; font-size: 12px;
            background: radial-gradient(circle at 40% 35%, #f0c090, #c07030);
            border-color: rgba(200,140,60,0.4);
        }
        .podium-3 .podium-block {
            height: 40px;
            background: linear-gradient(180deg, rgba(200,140,60,0.2) 0%, rgba(160,100,30,0.15) 100%);
            border: 0.5px solid rgba(200,140,60,0.2);
        }

        /* ── Table ── */
        .lb-table {
            width: 100%;
            border-collapse: collapse;
        }
        .lb-table thead tr {
            border-bottom: 0.5px solid rgba(255,255,255,0.08);
        }
        .lb-table thead th {
            color: rgba(255,255,255,0.35);
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 12px 20px;
            text-align: left;
        }
        .lb-table thead th:last-child { text-align: right; }

        .lb-table tbody tr {
            border-bottom: 0.5px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .lb-table tbody tr:hover {
            background: rgba(255,255,255,0.04);
        }
        .lb-table tbody tr:last-child { border-bottom: none; }

        /* Highlight current user */
        .lb-table tbody tr.is-me {
            background: rgba(80,160,255,0.08);
        }
        .lb-table tbody tr.is-me:hover {
            background: rgba(80,160,255,0.12);
        }

        .lb-table tbody td {
            padding: 13px 20px;
            color: rgba(255,255,255,0.75);
            font-size: 13px;
        }
        .lb-table tbody td:last-child { text-align: right; }

        .rank-cell {
            color: rgba(255,255,255,0.3);
            font-size: 12px;
            width: 40px;
        }
        .rank-medal { font-size: 16px; }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-initial {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(80,160,255,0.25);
            border: 0.5px solid rgba(80,160,255,0.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 500; color: rgba(140,200,255,0.9);
            flex-shrink: 0;
        }
        .me-badge {
            font-size: 10px;
            background: rgba(80,160,255,0.2);
            color: rgba(140,200,255,0.8);
            border: 0.5px solid rgba(80,160,255,0.3);
            border-radius: 8px;
            padding: 1px 7px;
            margin-left: 4px;
        }

        .topic-pill {
            display: inline-block;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 99px;
            background: rgba(255,255,255,0.07);
            border: 0.5px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.5);
        }

        .score-cell {
            font-weight: 500;
            color: rgba(255,255,255,0.9);
        }

        /* Score bar mini */
        .mini-bar-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-end;
        }
        .mini-bar {
            width: 60px; height: 4px;
            background: rgba(255,255,255,0.08);
            border-radius: 99px;
            overflow: hidden;
        }
        .mini-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, rgba(60,160,255,0.8), rgba(100,210,255,0.9));
        }

        /* Empty state */
        .empty {
            padding: 48px 32px;
            text-align: center;
            color: rgba(255,255,255,0.3);
            font-size: 14px;
        }
    </style>
</head>
<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        <div class="card-header">
            <div class="header-icon">🏆</div>
            <div>
                <h1>Leaderboard</h1>
                <p>Top {{ $scores->count() }} scores across all topics</p>
            </div>
        </div>

        @if($scores->count() > 0)

            {{-- Podium top 3 --}}
            @php
                $first  = $scores->get(0);
                $second = $scores->get(1);
                $third  = $scores->get(2);
            @endphp
            <div class="podium">
                {{-- 2nd --}}
                @if($second)
                    <div class="podium-item podium-2">
                        <div class="podium-avatar">{{ strtoupper(substr($second->user->name,0,1)) }}</div>
                        <div class="podium-name">{{ $second->user->name }}</div>
                        <div class="podium-score">{{ $second->score }}/{{ $second->total_questions }}</div>
                        <div class="podium-block">🥈</div>
                    </div>
                @endif

                {{-- 1st --}}
                @if($first)
                    <div class="podium-item podium-1">
                        <div class="podium-avatar">{{ strtoupper(substr($first->user->name,0,1)) }}</div>
                        <div class="podium-name">{{ $first->user->name }}</div>
                        <div class="podium-score">{{ $first->score }}/{{ $first->total_questions }}</div>
                        <div class="podium-block">🥇</div>
                    </div>
                @endif

                {{-- 3rd --}}
                @if($third)
                    <div class="podium-item podium-3">
                        <div class="podium-avatar">{{ strtoupper(substr($third->user->name,0,1)) }}</div>
                        <div class="podium-name">{{ $third->user->name }}</div>
                        <div class="podium-score">{{ $third->score }}/{{ $third->total_questions }}</div>
                        <div class="podium-block">🥉</div>
                    </div>
                @endif
            </div>

            {{-- Full table --}}
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
                        $isMe  = $attempt->user_id === Auth::id();
                        $pct   = $attempt->total_questions > 0
                                 ? round($attempt->score / $attempt->total_questions * 100)
                                 : 0;
                    @endphp
                    <tr class="{{ $isMe ? 'is-me' : '' }}">
                        <td class="rank-cell">
                            @if($i === 0) <span class="rank-medal">🥇</span>
                            @elseif($i === 1) <span class="rank-medal">🥈</span>
                            @elseif($i === 2) <span class="rank-medal">🥉</span>
                            @else {{ $i + 1 }}
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
                                    {{ $attempt->topic->icon ?? '' }} {{ $attempt->topic->name }}
                                </span>
                        </td>
                        <td>
                            <div class="mini-bar-wrap">
                                <span class="score-cell">{{ $attempt->score }}/{{ $attempt->total_questions }}</span>
                                <div class="mini-bar">
                                    <div class="mini-bar-fill" style="width:{{ $pct }}%"></div>
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
