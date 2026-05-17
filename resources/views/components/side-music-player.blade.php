<aside class="side-music-player" id="sideMusicPlayer" aria-label="Music player">
    <button type="button" class="side-music-tab" id="sideMusicTab" aria-label="Toggle music player">
        <span>Music</span>
    </button>

    <div class="side-music-shell">
        <div class="side-music-titlebar">
            <span>QuizMaster Player</span>
            <div class="side-music-dots">
                <i class="dot-min"></i>
                <i class="dot-max"></i>
                <i class="dot-close"></i>
            </div>
        </div>

        <div class="side-music-screen">
            <div class="side-music-track" id="sideMusicTrack">background.mp3</div>
            <div class="side-music-time" id="sideMusicTime">READY [0:00 / 0:00]</div>
        </div>

        <button type="button" class="side-music-progress" id="sideMusicProgress" aria-label="Seek music">
            <span id="sideMusicProgressFill"></span>
        </button>

        <div class="side-music-controls">
            <button type="button" class="side-music-btn" id="sideMusicPrev" aria-label="Previous track">⏮</button>
            <button type="button" class="side-music-btn side-music-play" id="sideMusicPlay" aria-label="Play or pause">▶</button>
            <button type="button" class="side-music-btn" id="sideMusicStop" aria-label="Stop">⏹</button>
            <button type="button" class="side-music-btn" id="sideMusicNext" aria-label="Next track">⏭</button>
        </div>

        <div class="side-music-volume">
            <span>🔈</span>
            <input type="range" id="sideMusicVolume" min="0" max="1" step="0.01" value="0.7" aria-label="Volume">
            <span>🔊</span>
        </div>
    </div>

    <audio id="sideMusicAudio" preload="auto"></audio>
</aside>




