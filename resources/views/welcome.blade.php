<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* ── Aero Nav Buttons ── */
            .aero-btn {
                position: relative;
                padding: 0.6rem 1.4rem;
                border-radius: 2rem;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.875rem;
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

            /* ── Player Shell — draggable & resizable ── */
            .player-wrap {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 10;
            }

            .player-window {
                width: 520px;
                border-radius: 10px;
                overflow: hidden;
                background: linear-gradient(160deg, rgba(200,220,240,0.82) 0%, rgba(180,205,228,0.75) 100%);
                border: 1.5px solid rgba(255,255,255,0.85);
                box-shadow: 0 12px 40px rgba(80,130,180,0.35), 0 1.5px 0 rgba(255,255,255,0.9) inset, 0 -1px 0 rgba(160,190,215,0.3) inset;
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                transform-origin: top left;
                font-family: 'Segoe UI', Tahoma, sans-serif;
                user-select: none;
            }

            /* Title bar — drag handle */
            .player-titlebar {
                background: linear-gradient(180deg, rgba(190,215,238,0.95) 0%, rgba(165,198,225,0.9) 100%);
                border-bottom: 1px solid rgba(255,255,255,0.7);
                padding: 5px 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: grab;
            }
            .player-titlebar:active { cursor: grabbing; }

            .player-title-text {
                font-size: 11px;
                font-weight: 700;
                color: #4a6d8c;
                text-shadow: 0 1px 0 rgba(255,255,255,0.8);
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .player-dots { display: flex; gap: 4px; }
            .player-dot {
                width: 12px; height: 12px;
                border-radius: 50%;
                border: 1px solid rgba(255,255,255,0.6);
            }
            .dot-close { background: linear-gradient(135deg, #ff9090, #dd5555); }
            .dot-min   { background: linear-gradient(135deg, #ffe080, #ccaa33); }
            .dot-max   { background: linear-gradient(135deg, #90dd90, #44aa44); }

            /* LCD screen */
            .player-screen {
                margin: 8px 8px 4px;
                border-radius: 7px;
                background: linear-gradient(180deg, rgba(10,25,45,0.88) 0%, rgba(5,18,35,0.92) 100%);
                border: 1px solid rgba(255,255,255,0.25);
                box-shadow: inset 0 2px 8px rgba(0,0,0,0.5), 0 1px 0 rgba(255,255,255,0.5);
                padding: 8px 10px;
                overflow: hidden;
                position: relative;
            }
            .player-screen::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 40%;
                border-radius: 7px 7px 0 0;
                background: linear-gradient(180deg, rgba(255,255,255,0.07) 0%, transparent 100%);
                pointer-events: none;
            }

            .player-welcome {
                font-size: 13px;
                font-weight: 700;
                color: #7de8ff;
                text-shadow: 0 0 8px rgba(100,220,255,0.8), 0 0 2px rgba(100,220,255,0.5);
                letter-spacing: 0.04em;
                text-align: center;
                margin-bottom: 5px;
            }

            .player-marquee-wrap { 
                overflow: hidden; 
                width: 100%;
                position: relative;
                height: 1.4em;
            }
            .player-marquee {
                position: absolute;
                white-space: nowrap;
                font-size: 11px;
                color: #50c8ff;
                text-shadow: 0 0 6px rgba(80,200,255,0.7);
                letter-spacing: 0.06em;
                top: 0; left: 0;
            }

            .player-time {
                font-size: 10px;
                color: #38a0cc;
                margin-top: 4px;
                letter-spacing: 0.05em;
            }

            /* Progress */
            .player-progress-wrap {
                margin: 4px 8px;
                height: 6px;
                border-radius: 4px;
                background: rgba(0,30,60,0.5);
                border: 1px solid rgba(255,255,255,0.2);
                overflow: hidden;
                cursor: pointer;
            }
            .player-progress-bar {
                height: 100%;
                width: 0%;
                background: linear-gradient(90deg, #50aaff, #a0e0ff);
                border-radius: 4px;
                box-shadow: 0 0 6px rgba(80,180,255,0.7);
                transition: width 0.5s linear;
            }

            /* Control buttons */
            .player-buttons {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 6px 8px 4px;
            }
            .p-btn {
                width: 32px; height: 26px;
                border-radius: 6px;
                border: 1px solid rgba(255,255,255,0.55);
                background:
                    linear-gradient(180deg, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0.1) 49%, rgba(100,180,255,0.2) 50%, rgba(60,140,230,0.4) 100%),
                    linear-gradient(180deg, rgba(100,170,240,0.7) 0%, rgba(50,120,210,0.8) 100%);
                box-shadow: 0 2px 6px rgba(0,80,200,0.3), 0 1px 0 rgba(255,255,255,0.55) inset;
                color: #fff;
                font-size: 11px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.1s ease;
                position: relative;
                overflow: hidden;
            }
            .p-btn::before {
                content: '';
                position: absolute;
                top: 0; left: 5%; right: 5%;
                height: 45%;
                border-radius: 6px 6px 50% 50%;
                background: linear-gradient(180deg, rgba(255,255,255,0.65) 0%, rgba(255,255,255,0.05) 100%);
                pointer-events: none;
            }
            .p-btn:hover { box-shadow: 0 3px 10px rgba(0,100,255,0.45), 0 1px 0 rgba(255,255,255,0.65) inset; transform: translateY(-1px); }
            .p-btn:active { transform: translateY(0); box-shadow: 0 1px 3px rgba(0,80,200,0.3); }

            /* Volume */
            .player-volume-row {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 2px 10px 8px;
            }
            .vol-icon { font-size: 11px; color: #5a8ab0; }
            .vol-slider {
                -webkit-appearance: none;
                appearance: none;
                flex: 1;
                height: 4px;
                border-radius: 4px;
                background: linear-gradient(90deg, rgba(80,160,255,0.6), rgba(180,220,255,0.3));
                border: 1px solid rgba(255,255,255,0.35);
                outline: none;
                cursor: pointer;
            }
            .vol-slider::-webkit-slider-thumb {
                -webkit-appearance: none;
                width: 12px; height: 12px;
                border-radius: 50%;
                background: linear-gradient(135deg, #fff 30%, #a0d0ff 100%);
                border: 1px solid rgba(80,150,220,0.6);
                box-shadow: 0 1px 4px rgba(0,80,200,0.35);
                cursor: pointer;
            }

            /* Resize handle */
            .player-resize-handle {
                position: absolute;
                bottom: 0; right: 0;
                width: 18px; height: 18px;
                cursor: se-resize;
                display: flex;
                align-items: flex-end;
                justify-content: flex-end;
                padding: 3px;
                z-index: 20;
            }
            .player-resize-handle svg {
                opacity: 0.4;
                transition: opacity 0.15s;
            }
            .player-resize-handle:hover svg { opacity: 0.85; }
        </style>
    </head>
    <body style="margin: 0; padding: 0; min-height: 100vh; position: relative; background-image: url('/images/welcomebg.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">

        <canvas id="bubble-canvas"></canvas>

        @if (Route::has('login'))
            <nav style="position: absolute; top: 1.5rem; right: 1.5rem; display: flex; gap: 0.75rem; align-items: center; z-index: 10;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="aero-btn">Dashboard</a>
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
                    <div class="player-welcome">Welcome to QuizMaster!</div>
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

        <script>
            /* ── Playlist & Audio controls ── */
            const audio       = document.getElementById('bg-audio');
            const btnPlay     = document.getElementById('btn-play');
            const volSlider   = document.getElementById('vol-slider');
            const progressBar = document.getElementById('progress-bar');
            const timeDisplay = document.getElementById('player-time');
            const marqueeText = document.getElementById('marquee-text');

            // Playlist — name shown in marquee, src path
            const playlist = [
                { name: 'Jewelry - Bladee',  src: '/audio/background.mp3'  },
                { name: 'Hocus Pocus - Yung Lean', src: '/audio/background2.mp3' },
                { name: 'Smoking Kills - SmokeDope2016', src: '/audio/background3.mp3' },
            ];
            let currentTrack = 0;

            audio.volume = 0.7;

            function fmt(s) {
                const m = Math.floor(s / 60);
                const sec = Math.floor(s % 60).toString().padStart(2, '0');
                return `${m}:${sec}`;
            }

            /* ── Marquee scroll loop ── */
            const marqueeWrap   = marqueeText.parentElement;
            const MARQUEE_SPEED = 40; // px per second
            let marqueeX        = 0;
            let marqueeRAF      = null;
            let marqueeLastTime = null;

            function startMarquee() {
                marqueeX = marqueeWrap.offsetWidth;
                marqueeText.style.transform = `translateX(${marqueeX}px)`;
                marqueeLastTime = null;
                if (marqueeRAF) cancelAnimationFrame(marqueeRAF);
                marqueeRAF = requestAnimationFrame(tickMarquee);
            }

            function tickMarquee(ts) {
                if (!marqueeLastTime) marqueeLastTime = ts;
                const dt = (ts - marqueeLastTime) / 1000;
                marqueeLastTime = ts;
                marqueeX -= MARQUEE_SPEED * dt;
                if (marqueeX < -marqueeText.offsetWidth) {
                    marqueeX = marqueeWrap.offsetWidth;
                }
                marqueeText.style.transform = `translateX(${marqueeX}px)`;
                marqueeRAF = requestAnimationFrame(tickMarquee);
            }

            function loadTrack(index, autoplay = true) {
                currentTrack = (index + playlist.length) % playlist.length;
                const track = playlist[currentTrack];

                marqueeText.textContent = track.name;
                startMarquee();

                audio.src = track.src;

                if (autoplay) {
                    audio.play();
                    btnPlay.textContent = '⏸';
                }
            }

            audio.addEventListener('timeupdate', () => {
                const cur = audio.currentTime, dur = audio.duration || 0;
                progressBar.style.width = (dur ? cur / dur * 100 : 0) + '%';
                timeDisplay.textContent = `PLAYING [${fmt(cur)} / ${fmt(dur)}]`;
            });

            // Autoplay next track when current ends
            audio.addEventListener('ended', () => {
                loadTrack(currentTrack + 1, true);
            });

            btnPlay.addEventListener('click', () => {
                if (audio.src === '') loadTrack(0, true);
                else if (audio.paused) { audio.play(); btnPlay.textContent = '⏸'; }
                else                   { audio.pause(); btnPlay.textContent = '▶'; }
            });

            document.getElementById('btn-stop').addEventListener('click', () => {
                audio.pause(); audio.currentTime = 0; btnPlay.textContent = '▶';
            });

            // FIX 3: Prev/Next always autoplay
            document.getElementById('btn-prev').addEventListener('click', () => {
                loadTrack(currentTrack - 1, true);
            });

            document.getElementById('btn-next').addEventListener('click', () => {
                loadTrack(currentTrack + 1, true);
            });

            volSlider.addEventListener('input', () => { audio.volume = volSlider.value; });

            document.getElementById('progress-wrap').addEventListener('click', (e) => {
                const rect = e.currentTarget.getBoundingClientRect();
                audio.currentTime = ((e.clientX - rect.left) / rect.width) * audio.duration;
            });

            // Initialise marquee with first track name (no autoplay on page load — browser policy)
            loadTrack(0, false);

            /* ── Drag to move ── */
            const playerWrap    = document.getElementById('player-wrap');
            const playerWindow  = document.getElementById('player-window');
            const titlebar      = document.getElementById('player-titlebar');

            function initPosition() {
                const rect = playerWrap.getBoundingClientRect();
                playerWrap.style.left      = rect.left + 'px';
                playerWrap.style.bottom    = '';
                playerWrap.style.top       = rect.top + 'px';
                playerWrap.style.transform = 'none';
            }

            let dragging = false, dragOffX = 0, dragOffY = 0;

            titlebar.addEventListener('mousedown', (e) => {
                if (e.target.closest('#resize-handle')) return;
                initPosition();
                dragging = true;
                const rect = playerWrap.getBoundingClientRect();
                dragOffX = e.clientX - rect.left;
                dragOffY = e.clientY - rect.top;
                e.preventDefault();
            });

            document.addEventListener('mousemove', (e) => {
                if (!dragging) return;
                playerWrap.style.left = (e.clientX - dragOffX) + 'px';
                playerWrap.style.top  = (e.clientY - dragOffY) + 'px';
            });

            document.addEventListener('mouseup', () => { dragging = false; });

            /* ── Resize + scale inner content ── */
            const resizeHandle = document.getElementById('resize-handle');
            const BASE_WIDTH   = 520;
            const MIN_WIDTH    = 220;
            const MAX_WIDTH    = 700;

            let resizing = false, resizeStartX = 0, resizeStartW = 0;

            resizeHandle.addEventListener('mousedown', (e) => {
                initPosition();
                resizing     = true;
                resizeStartX = e.clientX;
                resizeStartW = playerWindow.offsetWidth;
                e.preventDefault();
                e.stopPropagation();
            });

            document.addEventListener('mousemove', (e) => {
                if (!resizing) return;
                const delta    = e.clientX - resizeStartX;
                const newWidth = Math.min(MAX_WIDTH, Math.max(MIN_WIDTH, resizeStartW + delta));
                const scale    = newWidth / BASE_WIDTH;

                playerWrap.style.width  = (newWidth) + 'px';
                playerWrap.style.height = (playerWindow.offsetHeight * scale) + 'px';

                playerWindow.style.transform = `scale(${scale})`;
                playerWindow.style.width      = BASE_WIDTH + 'px';
            });

            document.addEventListener('mouseup', () => { resizing = false; });
        </script>
    </body>
</html>