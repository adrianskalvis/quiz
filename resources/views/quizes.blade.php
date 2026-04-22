<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/quizes.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; overflow: hidden; height: 100vh; }

        .screen {
            width: 100%; height: 100vh; position: relative; overflow: hidden;
            background: url('/images/welcomebg.jpg') center/cover no-repeat;
        }
        .screen::before {
            content:''; position:absolute; inset:0;
            background: rgba(5,20,35,0.45);
            z-index:1;
        }
        .topbar {
            position: absolute; top: 0; left: 0; right: 0; z-index: 20;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 28px;
            background: rgba(255,255,255,0.06);
            border-bottom: 0.5px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
        }
        .hello { color: rgba(255,255,255,0.8); font-size: 13px; }
        .hello strong { color: #fff; }
        .nav { display: flex; gap: 8px; align-items: center; }
        .nav a, .nav button {
            color: rgba(255,255,255,0.65); font-size: 12px;
            padding: 4px 13px; border-radius: 16px;
            border: 0.5px solid rgba(255,255,255,0.18);
            background: rgba(255,255,255,0.07);
            cursor: pointer; text-decoration: none;
            font-family: inherit; transition: all .2s;
        }
        .nav a:hover, .nav button:hover {
            background: rgba(255,255,255,0.16); color: #fff;
        }
        .nav a.admin {
            border-color: rgba(255,200,80,0.45);
            color: rgba(255,205,100,0.9);
        }
        .center-ui {
            position: absolute; top: 52px; left: 0; right: 0; z-index: 10;
            display: flex; flex-direction: column; align-items: center;
            padding-top: 20px;
        }
        .title-row {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer; user-select: none; margin-bottom: 4px;
        }
        .title-row h1 {
            color: #fff; font-size: 30px; font-weight: 300; letter-spacing: -0.5px;
            text-shadow: 0 0 50px rgba(140,210,255,0.55);
        }
        .arrow {
            width: 0; height: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 9px solid rgba(255,255,255,0.7);
            transition: transform .3s; margin-top: 4px;
        }
        .arrow.open { transform: rotate(180deg); }
        .subtitle {
            color: rgba(255,255,255,0.38); font-size: 12px; margin-bottom: 12px;
        }
        .filter-panel {
            overflow: hidden; max-height: 0; opacity: 0;
            transition: max-height .38s ease, opacity .3s ease;
            display: flex; gap: 7px; flex-wrap: wrap;
            justify-content: center; padding: 0 20px;
        }
        .filter-panel.open { max-height: 80px; opacity: 1; }
        .fbtn {
            padding: 5px 14px; border-radius: 16px; font-size: 11px;
            cursor: pointer; border: 0.5px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.6); background: rgba(255,255,255,0.07);
            transition: all .2s; user-select: none; font-family: inherit;
        }
        .fbtn:hover { background: rgba(255,255,255,0.14); color: #fff; }
        .fbtn.active {
            background: rgba(255,255,255,0.2); color: #fff;
            border-color: rgba(255,255,255,0.45);
        }
        canvas#bubbleCanvas {
            position: absolute; inset: 0; z-index: 5; touch-action: none;
        }
    </style>
</head>
<body>
<div class="screen">
    <x-quiz-nav />

    <div class="center-ui">
        <div class="title-row" id="titleRow">
            <h1>Select quiz</h1>
            <div class="arrow" id="arrow"></div>
        </div>
        <div class="subtitle">Click a bubble to start &middot; {{ $topics->count() }} topics available</div>
        <div class="filter-panel" id="filterPanel">
            <button class="fbtn active" data-filter="all">All topics</button>
            @foreach($topics as $topic)
                <button class="fbtn" data-filter="{{ $topic->slug }}">{{ $topic->name }}</button>
            @endforeach
        </div>
    </div>

    <canvas id="bubbleCanvas"></canvas>
</div>

<script>
    window.QUIZ_TOPICS = {!! json_encode($topicsJson) !!};
</script>
</body>
</html>
