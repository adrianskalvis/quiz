<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} — Results</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: sans-serif;
            min-height: 100vh;
            background: url('/images/welcomebg.jpg') center/cover no-repeat fixed;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: rgba(5, 18, 32, 0.55);
            z-index: 0;
        }

        .page {
            position: relative; z-index: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 100px 20px 60px;
        }

        /* ── Result card ── */
        .card {
            width: 100%;
            max-width: 540px;
            background: rgba(255,255,255,0.08);
            border: 0.5px solid rgba(255,255,255,0.18);
            border-radius: 24px;
            backdrop-filter: blur(24px);
            overflow: hidden;
            text-align: center;
        }

        /* Gloss top sheen */
        .card::before {
            content: '';
            display: block;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        /* ── Header band ── */
        .card-header {
            padding: 32px 32px 24px;
            border-bottom: 0.5px solid rgba(255,255,255,0.1);
        }
        .topic-icon {
            font-size: 42px;
            display: block;
            margin-bottom: 8px;
            filter: drop-shadow(0 0 12px rgba(140,210,255,0.5));
        }
        .card-header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 500;
            letter-spacing: -0.3px;
            text-shadow: 0 0 40px rgba(140,210,255,0.5);
            margin-bottom: 2px;
        }
        .card-header .topic-name {
            color: rgba(255,255,255,0.45);
            font-size: 13px;
        }

        /* ── Score ring ── */
        .score-ring-wrap {
            padding: 32px 32px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ring-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }
        .ring-svg {
            transform: rotate(-90deg);
            width: 150px; height: 150px;
        }
        .ring-bg {
            fill: none;
            stroke: rgba(255,255,255,0.08);
            stroke-width: 10;
        }
        .ring-fill {
            fill: none;
            stroke-width: 10;
            stroke-linecap: round;
            stroke-dasharray: 408; /* 2π × 65 */
            stroke-dashoffset: 408;
            transition: stroke-dashoffset 1.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: drop-shadow(0 0 6px rgba(80,180,255,0.8));
        }
        .ring-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .ring-pct {
            color: #fff;
            font-size: 32px;
            font-weight: 500;
            line-height: 1;
            text-shadow: 0 0 20px rgba(140,210,255,0.6);
        }
        .ring-pct-sym {
            font-size: 16px;
            color: rgba(255,255,255,0.5);
        }

        /* ── Name + score text ── */
        .result-name {
            color: rgba(255,255,255,0.55);
            font-size: 13px;
            margin-bottom: 6px;
        }
        .result-name strong {
            color: #fff;
        }
        .result-score {
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            text-shadow: 0 0 30px rgba(140,210,255,0.4);
            margin-bottom: 6px;
        }
        .result-score span {
            color: rgba(255,255,255,0.4);
            font-size: 18px;
            font-weight: 400;
        }
        .result-message {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 0;
            font-style: italic;
        }

        /* ── Aero progress bar (score bar) ── */
        .score-bar-wrap {
            padding: 0 32px 28px;
        }
        .score-bar-track {
            width: 100%;
            height: 16px;
            background: rgba(0,0,0,0.25);
            border-radius: 99px;
            border: 0.5px solid rgba(255,255,255,0.1);
            overflow: hidden;
            position: relative;
        }
        .score-bar-fill {
            height: 100%;
            border-radius: 99px;
            width: 0%;
            transition: width 1.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .score-bar-fill::after {
            content: '';
            position: absolute;
            top: 1px; left: 4px; right: 4px;
            height: 45%;
            background: linear-gradient(180deg, rgba(255,255,255,0.65) 0%, rgba(255,255,255,0) 100%);
            border-radius: 99px;
        }

        /* Color based on score */
        .bar-great {
            background: linear-gradient(180deg,
            rgba(255,255,255,0.5) 0%,
            rgba(80,220,140,0.9) 35%,
            rgba(30,180,90,1)    65%,
            rgba(60,200,120,0.8) 100%
            );
            box-shadow: 0 0 8px rgba(60,200,100,0.6), inset 0 1px 0 rgba(255,255,255,0.5);
        }
        .bar-good {
            background: linear-gradient(180deg,
            rgba(255,255,255,0.5) 0%,
            rgba(80,180,255,0.9) 35%,
            rgba(30,120,220,1)   65%,
            rgba(60,160,255,0.8) 100%
            );
            box-shadow: 0 0 8px rgba(80,180,255,0.6), inset 0 1px 0 rgba(255,255,255,0.5);
        }
        .bar-ok {
            background: linear-gradient(180deg,
            rgba(255,255,255,0.5) 0%,
            rgba(255,200,80,0.9) 35%,
            rgba(220,150,30,1)   65%,
            rgba(255,180,60,0.8) 100%
            );
            box-shadow: 0 0 8px rgba(220,160,40,0.6), inset 0 1px 0 rgba(255,255,255,0.5);
        }
        .bar-low {
            background: linear-gradient(180deg,
            rgba(255,255,255,0.5) 0%,
            rgba(255,100,80,0.9) 35%,
            rgba(220,50,30,1)    65%,
            rgba(255,80,60,0.8)  100%
            );
            box-shadow: 0 0 8px rgba(220,60,40,0.6), inset 0 1px 0 rgba(255,255,255,0.5);
        }

        /* ── Buttons ── */
        .btn-group {
            padding: 0 28px 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.22) 0%, rgba(255,255,255,0) 100%);
            pointer-events: none;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-retake {
            background: linear-gradient(180deg,
            rgba(100,210,150,0.9) 0%,
            rgba(40,170,90,1)    40%,
            rgba(20,140,70,1)    60%,
            rgba(60,190,110,0.9) 100%
            );
            box-shadow:
                0 0 0 1px rgba(80,200,120,0.4),
                0 4px 20px rgba(30,150,70,0.4),
                inset 0 1px 0 rgba(255,255,255,0.3),
                inset 0 -1px 0 rgba(0,80,30,0.3);
        }
        .btn-retake:hover {
            box-shadow:
                0 0 0 1px rgba(100,220,140,0.5),
                0 8px 28px rgba(30,160,80,0.5),
                inset 0 1px 0 rgba(255,255,255,0.35);
        }

        .btn-topics {
            background: linear-gradient(180deg,
            rgba(100,190,255,0.9) 0%,
            rgba(40,130,230,1)   40%,
            rgba(20,100,210,1)   60%,
            rgba(60,150,255,0.9) 100%
            );
            box-shadow:
                0 0 0 1px rgba(120,200,255,0.4),
                0 4px 20px rgba(40,120,220,0.4),
                inset 0 1px 0 rgba(255,255,255,0.3),
                inset 0 -1px 0 rgba(0,40,120,0.3);
        }
        .btn-topics:hover {
            box-shadow:
                0 0 0 1px rgba(140,210,255,0.5),
                0 8px 28px rgba(40,120,220,0.5),
                inset 0 1px 0 rgba(255,255,255,0.35);
        }

        /* ── Leaderboard teaser ── */
        .lb-teaser {
            padding: 0 28px 24px;
        }
        .lb-teaser a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: rgba(255,255,255,0.4);
            font-size: 12px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .lb-teaser a:hover { color: rgba(255,255,255,0.75); }
    </style>
</head>
<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <span class="topic-icon">{{ $topic->icon }}</span>
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

<script>
    (function(){
        const percentage = {{ $percentage }};
        const circumference = 2 * Math.PI * 65; // 408.4

        // Animate ring
        const ring = document.getElementById('ringFill');
        ring.style.strokeDasharray  = circumference;
        ring.style.strokeDashoffset = circumference;

        // Animate percentage counter
        const pctEl = document.getElementById('pctCount');
        const bar   = document.getElementById('scoreBar');

        // Trigger after paint
        requestAnimationFrame(() => {
            setTimeout(() => {
                // Ring
                const offset = circumference - (percentage / 100) * circumference;
                ring.style.strokeDashoffset = offset;

                // Bar
                bar.style.width = percentage + '%';

                // Count up number
                let current = 0;
                const step  = Math.ceil(percentage / 60);
                const timer = setInterval(() => {
                    current = Math.min(current + step, percentage);
                    pctEl.innerHTML = current + '<span class="ring-pct-sym">%</span>';
                    if (current >= percentage) clearInterval(timer);
                }, 24);
            }, 120);
        });
    })();
</script>
</body>
</html>
