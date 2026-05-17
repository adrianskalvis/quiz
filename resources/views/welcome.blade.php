<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'QuizMaster') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/css/pages/welcome-page.css', 'resources/js/app.js'])
        
    </head>
    <body class="welcome-page">

        <canvas id="bubble-canvas"></canvas>

        @if (Route::has('login'))
            <nav class="welcome-nav">
                @auth
                    <a href="{{ route('quizes') }}" class="aero-btn">All Quizes</a>
                @else
                    <a href="{{ route('login') }}" class="aero-btn">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="aero-btn">Register</a>
                    @endif
                @endauth
            </nav>
        @endif

        <!-- Player -->
        <div class="player-wrap" id="player-wrap">
            <div class="player-window" id="player-window">

                <div class="player-titlebar" id="player-titlebar">
                    <span class="player-title-text">QuizMaster Player</span>
                    <div class="player-dots">
                        <div class="player-dot dot-min"></div>
                        <div class="player-dot dot-max"></div>
                        <div class="player-dot dot-close"></div>
                    </div>
                </div>

                <div class="player-screen">
                    <div class="player-welcome" id="player-welcome">Welcome to QuizMaster!</div>
                    <div class="player-marquee-wrap">
                        <span class="player-marquee" id="marquee-text">background.mp3</span>
                    </div>
                    <div class="player-time" id="player-time">PLAYING [0:00 / 0:00]</div>
                </div>

                <div class="player-progress-wrap" id="progress-wrap">
                    <div class="player-progress-bar" id="progress-bar"></div>
                </div>

                <div class="player-buttons">
                    <button class="p-btn" id="btn-prev">⏮</button>
                    <button class="p-btn" id="btn-play">▶</button>
                    <button class="p-btn" id="btn-stop">⏹</button>
                    <button class="p-btn" id="btn-next">⏭</button>
                </div>

                <div class="player-volume-row">
                    <span class="vol-icon">🔈</span>
                    <input type="range" class="vol-slider" id="vol-slider" min="0" max="1" step="0.01" value="0.7">
                    <span class="vol-icon">🔊</span>
                </div>

                <!-- Resize grip -->
                <div class="player-resize-handle" id="resize-handle">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path d="M9 1L1 9M9 5L5 9M9 9" stroke="#4a6d8c" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>

            </div>
        </div>

        <audio id="bg-audio" preload="auto"></audio>

        
    </body>
</html>
