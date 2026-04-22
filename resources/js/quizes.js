(function () {
    const canvas = document.getElementById('bubbleCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const screen = canvas.parentElement;
    const TOP_OFFSET = 140;

    function resize() {
        canvas.width  = screen.offsetWidth;
        canvas.height = screen.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const TOPICS = window.QUIZ_TOPICS || [];
    const HUES   = [200, 30, 165, 90, 330, 50, 280, 15, 260, 120];
    TOPICS.forEach((t, i) => t.hue = HUES[i % HUES.length]);

    function makeBubbles() {
        const cols   = Math.ceil(Math.sqrt(TOPICS.length + 1));
        const rows   = Math.ceil(TOPICS.length / cols);
        const cellW  = (canvas.width  * 0.85) / cols;
        const cellH  = ((canvas.height - TOP_OFFSET) * 0.75) / rows;
        const startX = canvas.width  * 0.075;
        const startY = TOP_OFFSET + (canvas.height - TOP_OFFSET) * 0.1;
        const baseR  = Math.min(cellW, cellH) * 0.38 * 1.45;

        // Each bubble gets a unique size variation ±18%
        const sizeVariants = [1.0, 0.82, 1.18, 0.9, 1.12, 0.85, 1.08, 0.95, 1.15, 0.88];

        return TOPICS.map((t, i) => {
            const col      = i % cols;
            const row      = Math.floor(i / cols);
            const sizeMult = sizeVariants[i % sizeVariants.length];
            return {
                ...t,
                x:        startX + cellW * col + cellW / 2 + (Math.random() - .5) * (cellW * 0.22),
                y:        startY + cellH * row + cellH / 2 + (Math.random() - .5) * (cellH * 0.22),
                r:        baseR * sizeVariants[i % sizeVariants.length],
                // Each bubble has its own independent float speed and drift
                vx:       (Math.random() - .5) * 0.45,
                vy:       (Math.random() - .5) * 0.45,
                phase:    Math.random() * Math.PI * 2,
                floatY:   Math.random() * Math.PI * 2, // start at random point in float cycle
                floatSpd: 0.008 + Math.random() * 0.009, // different float speeds per bubble
                floatAmp: 0.25 + Math.random() * 0.35,   // different float amplitudes
                driftX:   (Math.random() - .5) * 0.12,   // slow independent horizontal drift
                driftY:   (Math.random() - .5) * 0.08,
                visible:  true,
                scaleX:   1,
                scaleY:   1,
                dents:    [0, 0, 0, 0],
                dragging: false,
            };
        });
    }

    let bubbles    = makeBubbles();
    let dragBubble = null, dragOffX = 0, dragOffY = 0;
    let lastMX     = 0, lastMY = 0, mouseVX = 0, mouseVY = 0;

    /* ── Collision + dent ── */
    function resolveCollisions() {
        for (let i = 0; i < bubbles.length; i++) {
            const a = bubbles[i];
            if (!a.visible) continue;
            for (let j = i + 1; j < bubbles.length; j++) {
                const b = bubbles[j];
                if (!b.visible) continue;

                const dx   = b.x - a.x;
                const dy   = b.y - a.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                const minD = a.r + b.r + 4;

                if (dist < minD && dist > 0.01) {
                    const nx      = dx / dist;
                    const ny      = dy / dist;
                    const overlap = (minD - dist) * 0.15;

                    if (!a.dragging) { a.x -= nx * overlap; a.y -= ny * overlap; }
                    if (!b.dragging) { b.x += nx * overlap; b.y += ny * overlap; }

                    const relVx = b.vx - a.vx;
                    const relVy = b.vy - a.vy;
                    const dot   = relVx * nx + relVy * ny;

                    if (dot < 0) {
                        const impulse = dot * 0.18;
                        if (!a.dragging) { a.vx -= impulse * nx; a.vy -= impulse * ny; }
                        if (!b.dragging) { b.vx += impulse * nx; b.vy += impulse * ny; }
                    }

                    const MAX_V = 1.2;
                    [a, b].forEach(bub => {
                        const spd = Math.sqrt(bub.vx * bub.vx + bub.vy * bub.vy);
                        if (spd > MAX_V) { bub.vx = (bub.vx / spd) * MAX_V; bub.vy = (bub.vy / spd) * MAX_V; }
                    });

                    const realOverlap = (a.r + b.r) - dist;
                    if (realOverlap > 0) {
                        const angle = Math.atan2(dy, dx);
                        const dent  = Math.min(0.35, realOverlap / (a.r * 0.6));
                        applyDent(a, angle,           dent);
                        applyDent(b, angle + Math.PI, dent);
                    }
                }
            }
        }
    }

    function applyDent(b, angle, amount) {
        const norm = ((angle % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
        const idx  = norm / (Math.PI / 2);
        const lo   = Math.floor(idx) % 4;
        const hi   = (lo + 1) % 4;
        const frac = idx - Math.floor(idx);
        b.dents[lo] = Math.max(b.dents[lo], amount * (1 - frac));
        b.dents[hi] = Math.max(b.dents[hi], amount * frac);
    }

    /* ── Draw bubble ── */
    function drawBubble(b) {
        ctx.save();
        ctx.translate(b.x, b.y);
        ctx.scale(b.scaleX, b.scaleY);

        const r  = b.r;
        const h  = b.hue;
        const dt = b.dents[0], dr = b.dents[1], db = b.dents[2], dl = b.dents[3];
        const dp = r * 0.18;

        ctx.beginPath();
        ctx.moveTo(0, -r);
        ctx.bezierCurveTo(
            r * 0.55,       -r + dt * dp,
            r - dr * dp,    -r * 0.55,
            r, 0
        );
        ctx.bezierCurveTo(
            r - dr * dp,    r * 0.55,
            r * 0.55,       r - db * dp,
            0, r
        );
        ctx.bezierCurveTo(
            -r * 0.55,       r - db * dp,
            -(r - dl * dp),  r * 0.55,
            -r, 0
        );
        ctx.bezierCurveTo(
            -(r - dl * dp),  -r * 0.55,
            -r * 0.55,       -r + dt * dp,
            0, -r
        );
        ctx.closePath();

        ctx.save();
        ctx.clip();

        const rim = ctx.createRadialGradient(0, 0, r * .7, 0, 0, r);
        rim.addColorStop(0,    `hsla(${h},60%,80%,0)`);
        rim.addColorStop(0.78, `hsla(${h},80%,78%,0.1)`);
        rim.addColorStop(0.88, `hsla(${(h + 70)  % 360},90%,82%,0.28)`);
        rim.addColorStop(0.94, `hsla(${(h + 140) % 360},85%,88%,0.32)`);
        rim.addColorStop(1,    `hsla(${(h + 200) % 360},70%,92%,0.12)`);
        ctx.fillStyle = rim; ctx.fill();

        const body = ctx.createRadialGradient(-r * .2, -r * .25, 0, 0, 0, r * .95);
        body.addColorStop(0,   `hsla(${h},35%,100%,0.09)`);
        body.addColorStop(.45, `hsla(${h},25%,90%,0.04)`);
        body.addColorStop(1,   `hsla(${h},55%,80%,0.02)`);
        ctx.fillStyle = body; ctx.fill();

        const hl = ctx.createRadialGradient(-r * .28, -r * .35, 0, -r * .22, -r * .28, r * .4);
        hl.addColorStop(0,  'rgba(255,255,255,0.93)');
        hl.addColorStop(.3, 'rgba(255,255,255,0.55)');
        hl.addColorStop(.7, 'rgba(255,255,255,0.1)');
        hl.addColorStop(1,  'rgba(255,255,255,0)');
        ctx.fillStyle = hl; ctx.fill();

        const sp = ctx.createRadialGradient(r * .28, r * .32, 0, r * .28, r * .32, r * .17);
        sp.addColorStop(0, 'rgba(255,255,255,0.5)');
        sp.addColorStop(1, 'rgba(255,255,255,0)');
        ctx.fillStyle = sp; ctx.fill();

        ctx.restore();

        ctx.strokeStyle = `hsla(${h},70%,92%,0.4)`;
        ctx.lineWidth   = 1.2;
        ctx.stroke();

        ctx.font         = `${r * .5}px serif`;
        ctx.textAlign    = 'center';
        ctx.textBaseline = 'middle';
        ctx.globalAlpha  = .88;
        ctx.fillStyle    = 'white';
        ctx.fillText(b.icon, 0, -r * .06);
        ctx.globalAlpha  = 1;

        ctx.font         = `500 ${Math.max(9, r * .19)}px sans-serif`;
        ctx.fillStyle    = 'rgba(255,255,255,0.92)';
        ctx.textBaseline = 'top';
        ctx.fillText(b.label, 0, r * .28);

        ctx.font      = `${Math.max(8, r * .15)}px sans-serif`;
        ctx.fillStyle = 'rgba(255,255,255,0.5)';
        ctx.fillText(b.qs + ' Qs', 0, r * .28 + r * .22);

        ctx.restore();
    }

    /* ── Main loop ── */
    function tick() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        resolveCollisions();

        bubbles.forEach(b => {
            if (!b.visible) return;

            if (!b.dragging) {
                // Independent float per bubble using its own speed + amplitude
                b.floatY += b.floatSpd;
                b.x += b.vx + b.driftX + Math.sin(b.floatY * 0.6 + b.phase) * 0.08;
                b.y += b.vy + b.driftY + Math.sin(b.floatY       + b.phase) * b.floatAmp;

                const mg = b.r + 8;
                if (b.x < mg)                 { b.x = mg;                 b.vx =  Math.abs(b.vx); }
                if (b.x > canvas.width - mg)  { b.x = canvas.width - mg;  b.vx = -Math.abs(b.vx); }
                if (b.y < TOP_OFFSET + mg)    { b.y = TOP_OFFSET + mg;    b.vy =  Math.abs(b.vy); }
                if (b.y > canvas.height - mg) { b.y = canvas.height - mg; b.vy = -Math.abs(b.vy); }

                b.vx *= 0.97;
                b.vy *= 0.97;

                // Slowly decay drift so they settle
                b.driftX *= 0.999;
                b.driftY *= 0.999;

                b.scaleX += (1 - b.scaleX) * .08;
                b.scaleY += (1 - b.scaleY) * .08;
            } else {
                const spd = Math.sqrt(mouseVX * mouseVX + mouseVY * mouseVY);
                const sq  = Math.min(.28, spd * .012);
                const ang = Math.atan2(mouseVY, mouseVX);
                b.scaleX  = 1 + Math.cos(ang) * sq;
                b.scaleY  = 1 - Math.cos(ang) * sq * .65;
            }

            b.dents = b.dents.map(d => d * 0.78);
            drawBubble(b);
        });

        requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);

    /* ── Hit test ── */
    function hit(x, y) {
        for (let i = bubbles.length - 1; i >= 0; i--) {
            const b  = bubbles[i];
            if (!b.visible) continue;
            const dx = x - b.x, dy = y - b.y;
            if (Math.sqrt(dx * dx + dy * dy) < b.r) return b;
        }
        return null;
    }

    /* ── Mouse ── */
    canvas.addEventListener('mousedown', e => {
        const rect = canvas.getBoundingClientRect();
        const mx = e.clientX - rect.left, my = e.clientY - rect.top;
        const b = hit(mx, my);
        if (b) { dragBubble = b; b.dragging = true; dragOffX = mx - b.x; dragOffY = my - b.y; }
    });

    canvas.addEventListener('mousemove', e => {
        const rect = canvas.getBoundingClientRect();
        const mx = e.clientX - rect.left, my = e.clientY - rect.top;
        mouseVX = mx - lastMX; mouseVY = my - lastMY;
        lastMX = mx; lastMY = my;
        if (dragBubble) { dragBubble.x = mx - dragOffX; dragBubble.y = my - dragOffY; }
        canvas.style.cursor = dragBubble ? 'grabbing' : (hit(mx, my) ? 'grab' : 'default');
    });

    canvas.addEventListener('mouseup', () => {
        if (dragBubble) {
            dragBubble.vx = mouseVX * .2;
            dragBubble.vy = mouseVY * .2;
            dragBubble.dragging = false;
            dragBubble = null;
        }
    });

    canvas.addEventListener('click', e => {
        if (Math.abs(mouseVX) < 4 && Math.abs(mouseVY) < 4) {
            const rect = canvas.getBoundingClientRect();
            const b = hit(e.clientX - rect.left, e.clientY - rect.top);
            if (b) window.location.href = b.url;
        }
    });

    /* ── Touch ── */
    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        const rect  = canvas.getBoundingClientRect();
        const touch = e.touches[0];
        const mx = touch.clientX - rect.left, my = touch.clientY - rect.top;
        const b = hit(mx, my);
        if (b) { dragBubble = b; b.dragging = true; dragOffX = mx - b.x; dragOffY = my - b.y; }
    }, { passive: false });

    canvas.addEventListener('touchmove', e => {
        e.preventDefault();
        const rect  = canvas.getBoundingClientRect();
        const touch = e.touches[0];
        const mx = touch.clientX - rect.left, my = touch.clientY - rect.top;
        mouseVX = mx - lastMX; mouseVY = my - lastMY;
        lastMX = mx; lastMY = my;
        if (dragBubble) { dragBubble.x = mx - dragOffX; dragBubble.y = my - dragOffY; }
    }, { passive: false });

    canvas.addEventListener('touchend', e => {
        e.preventDefault();
        if (dragBubble) {
            if (Math.abs(mouseVX) < 4 && Math.abs(mouseVY) < 4) {
                window.location.href = dragBubble.url;
            }
            dragBubble.vx = mouseVX * .2;
            dragBubble.vy = mouseVY * .2;
            dragBubble.dragging = false;
            dragBubble = null;
        }
    }, { passive: false });

    /* ── Filter ── */
    const titleRow    = document.getElementById('titleRow');
    const arrow       = document.getElementById('arrow');
    const filterPanel = document.getElementById('filterPanel');
    let panelOpen     = false;

    if (titleRow) {
        titleRow.addEventListener('click', () => {
            panelOpen = !panelOpen;
            arrow.classList.toggle('open', panelOpen);
            filterPanel.classList.toggle('open', panelOpen);
        });
    }

    document.querySelectorAll('.fbtn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            document.querySelectorAll('.fbtn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            bubbles.forEach(b => {
                const show = filter === 'all' || b.slug === filter;
                if (show && !b.visible) { b.scaleX = 0.01; b.scaleY = 0.01; }
                b.visible = show;
            });
        });
    });

})();
