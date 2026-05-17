(() => {
            /* ── Playlist & Audio controls ── */
            const audio       = document.getElementById('bg-audio');
            const btnPlay     = document.getElementById('btn-play');
            const volSlider   = document.getElementById('vol-slider');
            const progressBar = document.getElementById('progress-bar');
            const timeDisplay = document.getElementById('player-time');
            const marqueeText = document.getElementById('marquee-text');
            const playerWrap    = document.getElementById('player-wrap');
            const playerWindow  = document.getElementById('player-window');
            const titlebar      = document.getElementById('player-titlebar');
            const resizeHandle = document.getElementById('resize-handle');

            if (!audio || !btnPlay || !volSlider || !progressBar || !timeDisplay || !marqueeText || !playerWrap || !playerWindow || !titlebar || !resizeHandle) {
                return;
            }

            // Playlist — name shown in marquee, src path
            const playlist = [
                { name: 'Jewelry - Bladee',  src: '/audio/background.mp3'  },
                { name: 'Hocus Pocus - Yung Lean', src: '/audio/background2.mp3' },
                { name: 'Smoking Kills - SmokeDope2016', src: '/audio/background3.mp3' },
            ];
            const musicStorageKey = 'quizmaster.musicState';
            const defaultMusicState = {
                track: 0,
                time: 0,
                volume: 0.7,
                playing: false,
                open: false,
                updatedAt: Date.now(),
            };

            function readMusicState() {
                try {
                    return { ...defaultMusicState, ...JSON.parse(localStorage.getItem(musicStorageKey) || '{}') };
                } catch {
                    return { ...defaultMusicState };
                }
            }

            let musicState = readMusicState();
            let currentTrack = Number.isInteger(musicState.track) ? musicState.track : 0;
            let leavingPage = false;

            audio.volume = Math.min(1, Math.max(0, Number(musicState.volume) || 0.7));
            volSlider.value = audio.volume;

            function saveMusicState(overrides = {}) {
                const savedTime = Object.prototype.hasOwnProperty.call(overrides, 'time')
                    ? Number(overrides.time) || 0
                    : (Number.isFinite(audio.currentTime) ? audio.currentTime : musicState.time);

                musicState = {
                    ...musicState,
                    track: currentTrack,
                    time: savedTime,
                    volume: audio.volume,
                    playing: !audio.paused,
                    updatedAt: Date.now(),
                    ...overrides,
                };
                localStorage.setItem(musicStorageKey, JSON.stringify(musicState));
            }

            function resumeTimeFromMusicState(savedState) {
                const baseTime = Number(savedState.time) || 0;
                const savedAt = Number(savedState.updatedAt) || Date.now();

                if (!savedState.playing) return baseTime;

                return baseTime + Math.max(0, (Date.now() - savedAt) / 1000);
            }

            function clampMusicTime(time, duration) {
                const safeTime = Math.max(0, Number(time) || 0);

                if (!Number.isFinite(duration) || duration <= 0) return safeTime;

                return Math.min(safeTime, Math.max(0, duration - 0.25));
            }

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

            function loadTrack(index, autoplay = true, restoreTime = 0) {
                currentTrack = (index + playlist.length) % playlist.length;
                const track = playlist[currentTrack];

                marqueeText.textContent = track.name;
                startMarquee();

                audio.src = track.src;
                audio.addEventListener('loadedmetadata', () => {
                    const targetTime = clampMusicTime(restoreTime, audio.duration);
                    let started = false;
                    const startPlayback = () => {
                        if (started) return;
                        started = true;
                        audio.play().catch(() => saveMusicState({ playing: false }));
                    };

                    if (targetTime > 0 && autoplay) {
                        audio.addEventListener('seeked', startPlayback, { once: true });
                    }

                    if (targetTime > 0) {
                        audio.currentTime = targetTime;
                    }

                    saveMusicState({ playing: autoplay, time: targetTime });

                    if (autoplay) {
                        btnPlay.textContent = '⏸';
                        if (targetTime > 0) {
                            window.setTimeout(startPlayback, 160);
                        } else {
                            startPlayback();
                        }
                    }
                }, { once: true });
            }

            audio.addEventListener('timeupdate', () => {
                const cur = audio.currentTime, dur = audio.duration || 0;
                progressBar.style.width = (dur ? cur / dur * 100 : 0) + '%';
                timeDisplay.textContent = `PLAYING [${fmt(cur)} / ${fmt(dur)}]`;
                saveMusicState();
            });

            // Autoplay next track when current ends
            audio.addEventListener('ended', () => {
                loadTrack(currentTrack + 1, true);
            });

            btnPlay.addEventListener('click', () => {
                if (audio.src === '') loadTrack(0, true);
                else if (audio.paused) {
                    audio.play().catch(() => saveMusicState({ playing: false }));
                    btnPlay.textContent = '⏸';
                    saveMusicState({ playing: true });
                }
                else {
                    audio.pause();
                    btnPlay.textContent = '▶';
                    saveMusicState({ playing: false });
                }
            });

            document.getElementById('btn-stop').addEventListener('click', () => {
                audio.pause(); audio.currentTime = 0; btnPlay.textContent = '▶';
                saveMusicState({ time: 0, playing: false });
            });

            // FIX 3: Prev/Next always autoplay
            document.getElementById('btn-prev').addEventListener('click', () => {
                loadTrack(currentTrack - 1, true);
            });

            document.getElementById('btn-next').addEventListener('click', () => {
                loadTrack(currentTrack + 1, true);
            });

            volSlider.addEventListener('input', () => {
                audio.volume = volSlider.value;
                saveMusicState();
            });

            document.getElementById('progress-wrap').addEventListener('click', (e) => {
                const rect = e.currentTarget.getBoundingClientRect();
                audio.currentTime = ((e.clientX - rect.left) / rect.width) * audio.duration;
                saveMusicState();
            });

            // Initialise marquee with first track name (no autoplay on page load — browser policy)
            loadTrack(currentTrack, Boolean(musicState.playing), resumeTimeFromMusicState(musicState));
            btnPlay.textContent = musicState.playing ? '⏸' : '▶';

            audio.addEventListener('play', () => saveMusicState({ playing: true }));
            audio.addEventListener('pause', () => {
                if (!leavingPage && document.visibilityState !== 'hidden') saveMusicState({ playing: false });
            });
            window.addEventListener('pagehide', () => {
                leavingPage = true;
                saveMusicState({ playing: !audio.paused });
            });
            window.addEventListener('beforeunload', () => {
                leavingPage = true;
                saveMusicState({ playing: !audio.paused });
            });
            document.addEventListener('visibilitychange', () => saveMusicState());

            const welcomePrompt = document.getElementById('player-welcome');
            const welcomeMessages = [
                'Welcome to QuizMaster!',
                'Log In OR Register To Start!',
            ];
            let welcomeIndex = 0;

            function rotateWelcomePrompt() {
                welcomePrompt.textContent = welcomeMessages[welcomeIndex];
                welcomePrompt.classList.remove('is-blinking');
                void welcomePrompt.offsetWidth;
                welcomePrompt.classList.add('is-blinking');
                welcomeIndex = (welcomeIndex + 1) % welcomeMessages.length;
            }

            rotateWelcomePrompt();
            setInterval(rotateWelcomePrompt, 2000);

            /* ── Drag to move ── */
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
})();
