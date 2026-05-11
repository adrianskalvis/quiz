<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/quizes.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Instrument Sans', sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        .screen {
            width: 100%; height: 100vh; position: relative; overflow: hidden;
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

        /* Aero ghost button (for logout / secondary) */
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
            position: absolute; top: 0; left: 0; right: 0; z-index: 20;
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

        /* ── Center UI ── */
        .center-ui {
            position: absolute;
            top: 64px; left: 0; right: 0; z-index: 10;
            display: flex; flex-direction: column; align-items: center;
            padding-top: 20px;
        }

        .title-row {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer; user-select: none; margin-bottom: 4px;
        }
        .title-row h1 {
            color: #fff;
            font-size: 30px;
            font-weight: 300;
            letter-spacing: -0.5px;
            text-shadow: 0 0 50px rgba(140,210,255,0.65), 0 2px 12px rgba(0,0,0,0.9), 0 0 40px rgba(0,0,0,0.6);
        }

        /* Aero chevron pill */
        .arrow-pill {
            display: flex; align-items: center; justify-content: center;
            width: 24px; height: 24px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.45);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.45) 0%, rgba(255,255,255,0.1) 48%, rgba(100,200,255,0.2) 50%, rgba(60,160,255,0.4) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.65) 0%, rgba(30,120,230,0.8) 100%);
            box-shadow: 0 2px 6px rgba(0,100,255,0.3), 0 1px 0 rgba(255,255,255,0.55) inset;
            transition: transform .3s, box-shadow .15s;
            margin-top: 3px;
            overflow: hidden;
            position: relative;
        }
        .arrow-pill::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 45%;
            border-radius: 50% 50% 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }
        .arrow-pill svg {
            transition: transform .3s;
            position: relative; z-index: 1;
        }
        .arrow-pill.open svg { transform: rotate(180deg); }

        .subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            margin-bottom: 14px;
            text-shadow: 0 1px 6px rgba(0,0,0,0.9), 0 0 20px rgba(0,0,0,0.7);
            letter-spacing: 0.02em;
        }

        /* ── Filter panel with aero glass ── */
        .filter-panel {
            overflow: hidden; max-height: 0; opacity: 0;
            transition: max-height .38s ease, opacity .3s ease;
            display: flex; gap: 7px; flex-wrap: wrap;
            justify-content: center; padding: 0 20px;
        }
        .filter-panel.open { max-height: 80px; opacity: 1; }

        .fbtn {
            position: relative;
            padding: 5px 14px; border-radius: 16px; font-size: 11px;
            cursor: pointer;
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            background: rgba(255,255,255,0.13);
            backdrop-filter: blur(6px);
            transition: all .2s; user-select: none;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            overflow: hidden;
            text-shadow: 0 1px 5px rgba(0,0,0,0.8);
        }
        .fbtn::before {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 45%;
            border-radius: 16px 16px 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.35) 0%, transparent 100%);
            pointer-events: none;
        }
        .fbtn:hover {
            background: rgba(255,255,255,0.22);
            border-color: rgba(255,255,255,0.55);
            color: #fff;
            transform: translateY(-1px);
        }
        .fbtn.active {
            border-color: rgba(255,255,255,0.55);
            color: #fff;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0.12) 48%, rgba(100,200,255,0.22) 50%, rgba(60,160,255,0.42) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.65) 0%, rgba(30,120,230,0.8) 100%);
            box-shadow: 0 2px 8px rgba(0,100,255,0.3), 0 1px 0 rgba(255,255,255,0.55) inset;
        }

        canvas#bubbleCanvas {
            position: absolute; inset: 0; z-index: 5; touch-action: none;
        }
    </style>
</head>
<body>
<div class="screen">

    <!-- Aero top bar -->
    <div class="topbar">
        <!-- Left: greeting -->
        <div class="hello">Hello, <strong>{{ Auth::user()->name }}</strong></div>

        <!-- Center spacer -->
        <div></div>

        <!-- Right: nav -->
        <nav class="nav">
            @if(Auth::user()->is_admin ?? false)
                <a href="{{ route('admin.index') }}" class="aero-btn" style="
                    background:
                        linear-gradient(180deg,rgba(255,255,255,0.5) 0%,rgba(255,255,255,0.12) 48%,rgba(255,200,60,0.3) 50%,rgba(220,160,0,0.55) 100%),
                        linear-gradient(180deg,rgba(255,200,80,0.75) 0%,rgba(200,140,0,0.9) 100%);
                    box-shadow:0 2px 8px rgba(200,140,0,0.4),0 1px 0 rgba(255,255,255,0.6) inset;
                ">Admin</a>
            @endif
            <a href="{{ route('leaderboard') }}" class="aero-btn-ghost">Leaderboard</a>
            <a href="{{ route('scores') }}" class="aero-btn-ghost">My scores</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="aero-btn-ghost">Log out</button>
            </form>
        </nav>
    </div>

    <!-- Center UI -->
    <div class="center-ui">
        <div class="title-row" id="titleRow">
            <h1>Select quiz</h1>
            <div class="arrow-pill" id="arrowPill">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                    <path d="M2 3.5L5 6.5L8 3.5" stroke="rgba(255,255,255,0.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="subtitle">Click a bubble to start &middot; {{ $topics->count() }} topics available</div>
        <div class="filter-panel" id="filterPanel">
            @foreach($topics as $topic)
                <button class="fbtn" data-filter="{{ $topic->slug }}">{{ $topic->name }}</button>
            @endforeach
        </div>
    </div>

    <canvas id="bubbleCanvas"></canvas>
</div>

<script>
    window.QUIZ_TOPICS = {!! json_encode($topicsJson) !!};

    // Arrow toggle
    const titleRow   = document.getElementById('titleRow');
    const arrowPill  = document.getElementById('arrowPill');
    const filterPanel = document.getElementById('filterPanel');

    titleRow.addEventListener('click', () => {
        const open = filterPanel.classList.toggle('open');
        arrowPill.classList.toggle('open', open);
    });

    // Filter buttons
    document.querySelectorAll('.fbtn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.fbtn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            // Dispatch filter event for quizes.js
            window.dispatchEvent(new CustomEvent('quiz-filter', { detail: btn.dataset.filter }));
        });
    });
</script>
</body>
</html>