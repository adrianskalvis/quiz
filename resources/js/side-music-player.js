    (() => {
        const root = document.getElementById('sideMusicPlayer');
        if (!root || root.dataset.ready === 'true') return;
        root.dataset.ready = 'true';

        const storageKey = 'quizmaster.musicState';
        const playlist = [
            { name: 'Jewelry - Bladee', src: '/audio/background.mp3' },
            { name: 'Hocus Pocus - Yung Lean', src: '/audio/background2.mp3' },
            { name: 'Smoking Kills - SmokeDope2016', src: '/audio/background3.mp3' },
        ];

        const audio = document.getElementById('sideMusicAudio');
        const tab = document.getElementById('sideMusicTab');
        const trackEl = document.getElementById('sideMusicTrack');
        const timeEl = document.getElementById('sideMusicTime');
        const playBtn = document.getElementById('sideMusicPlay');
        const prevBtn = document.getElementById('sideMusicPrev');
        const nextBtn = document.getElementById('sideMusicNext');
        const stopBtn = document.getElementById('sideMusicStop');
        const volume = document.getElementById('sideMusicVolume');
        const progress = document.getElementById('sideMusicProgress');
        const progressFill = document.getElementById('sideMusicProgressFill');

        const defaultState = {
            track: 0,
            time: 0,
            volume: 0.7,
            playing: false,
            open: false,
            updatedAt: Date.now(),
        };

        function readState() {
            try {
                return { ...defaultState, ...JSON.parse(localStorage.getItem(storageKey) || '{}') };
            } catch {
                return { ...defaultState };
            }
        }

        let state = readState();
        let currentTrack = Number.isInteger(state.track) ? state.track : 0;
        let isLeavingPage = false;

        function fmt(seconds) {
            const safe = Number.isFinite(seconds) ? seconds : 0;
            const m = Math.floor(safe / 60);
            const s = Math.floor(safe % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        }

        function saveState(overrides = {}) {
            const savedTime = Object.prototype.hasOwnProperty.call(overrides, 'time')
                ? Number(overrides.time) || 0
                : (Number.isFinite(audio.currentTime) ? audio.currentTime : state.time);

            state = {
                ...state,
                track: currentTrack,
                time: savedTime,
                volume: audio.volume,
                playing: !audio.paused,
                open: root.classList.contains('is-open'),
                updatedAt: Date.now(),
                ...overrides,
            };
            localStorage.setItem(storageKey, JSON.stringify(state));
        }

        function resumeTimeFromState(savedState) {
            const baseTime = Number(savedState.time) || 0;
            const savedAt = Number(savedState.updatedAt) || Date.now();

            if (!savedState.playing) return baseTime;

            return baseTime + Math.max(0, (Date.now() - savedAt) / 1000);
        }

        function clampTime(time, duration) {
            const safeTime = Math.max(0, Number(time) || 0);

            if (!Number.isFinite(duration) || duration <= 0) return safeTime;

            return Math.min(safeTime, Math.max(0, duration - 0.25));
        }

        function updateUi() {
            const duration = audio.duration || 0;
            const current = audio.currentTime || 0;
            const status = audio.paused ? 'READY' : 'PLAYING';

            trackEl.textContent = playlist[currentTrack].name;
            timeEl.textContent = `${status} [${fmt(current)} / ${fmt(duration)}]`;
            playBtn.textContent = audio.paused ? '▶' : '⏸';
            progressFill.style.width = duration ? `${(current / duration) * 100}%` : '0%';
        }

        function loadTrack(index, restoreTime = 0, autoplayAfterLoad = false) {
            currentTrack = (index + playlist.length) % playlist.length;
            audio.src = playlist[currentTrack].src;
            trackEl.textContent = playlist[currentTrack].name;

            audio.addEventListener('loadedmetadata', () => {
                const targetTime = clampTime(restoreTime, audio.duration);
                let started = false;
                const startPlayback = () => {
                    if (started) return;
                    started = true;
                    play();
                };

                if (targetTime > 0 && autoplayAfterLoad) {
                    audio.addEventListener('seeked', startPlayback, { once: true });
                }

                if (targetTime > 0) {
                    audio.currentTime = targetTime;
                }

                updateUi();
                saveState({ time: targetTime, playing: autoplayAfterLoad });

                if (autoplayAfterLoad) {
                    if (targetTime > 0) {
                        window.setTimeout(startPlayback, 160);
                    } else {
                        startPlayback();
                    }
                }
            }, { once: true });
        }

        async function play() {
            try {
                await audio.play();
            } catch {
                saveState({ playing: false });
            }
            updateUi();
            saveState();
        }

        function pause() {
            audio.pause();
            updateUi();
            saveState({ playing: false });
        }

        function changeTrack(nextIndex, autoplay = true) {
            loadTrack(nextIndex, 0, autoplay);
            saveState({ time: 0, playing: autoplay });
            updateUi();
        }

        if (state.open) root.classList.add('is-open');
        audio.volume = Math.min(1, Math.max(0, Number(state.volume) || 0.7));
        volume.value = audio.volume;
        loadTrack(currentTrack, resumeTimeFromState(state), Boolean(state.playing));

        tab.addEventListener('click', () => {
            root.classList.toggle('is-open');
            saveState();
        });

        playBtn.addEventListener('click', () => {
            if (audio.paused) play();
            else pause();
        });

        stopBtn.addEventListener('click', () => {
            audio.pause();
            audio.currentTime = 0;
            updateUi();
            saveState({ time: 0, playing: false });
        });

        prevBtn.addEventListener('click', () => changeTrack(currentTrack - 1, true));
        nextBtn.addEventListener('click', () => changeTrack(currentTrack + 1, true));

        volume.addEventListener('input', () => {
            audio.volume = Number(volume.value);
            saveState();
        });

        progress.addEventListener('click', (event) => {
            const duration = audio.duration || 0;
            if (!duration) return;

            const rect = progress.getBoundingClientRect();
            audio.currentTime = ((event.clientX - rect.left) / rect.width) * duration;
            updateUi();
            saveState();
        });

        audio.addEventListener('timeupdate', () => {
            updateUi();
            saveState();
        });
        audio.addEventListener('play', () => {
            updateUi();
            saveState({ playing: true });
        });
        audio.addEventListener('pause', () => {
            if (isLeavingPage || document.visibilityState === 'hidden') return;
            updateUi();
            saveState({ playing: false });
        });
        audio.addEventListener('ended', () => changeTrack(currentTrack + 1, true));

        window.addEventListener('pagehide', () => {
            isLeavingPage = true;
            saveState({ playing: !audio.paused });
        });
        window.addEventListener('beforeunload', () => {
            isLeavingPage = true;
            saveState({ playing: !audio.paused });
        });
        document.addEventListener('visibilitychange', () => saveState());

        updateUi();
    })();
