import '../css/welcome.css';

const canvas = document.getElementById('bubble-canvas');
const ctx = canvas.getContext('2d');

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

const TINTS = [
    [120, 210, 255], // aqua
    [80,  170, 255], // sky blue
    [140, 230, 200], // mint green
    [180, 210, 255], // lavender blue
    [255, 255, 255], // pure white
];

function createBubble(preplace = false) {
    const [r, g, b] = TINTS[Math.floor(Math.random() * TINTS.length)];
    return {
        x:           Math.random() * canvas.width,
        y:           preplace ? Math.random() * canvas.height : canvas.height + Math.random() * 120,
        radius:      Math.random() * 38 + 8,
        speed:       Math.random() * 0.8 + 0.3,
        drift:       (Math.random() - 0.5) * 0.4,
        wobble:      Math.random() * Math.PI * 2,
        wobbleSpeed: Math.random() * 0.015 + 0.005,
        wobbleAmp:   Math.random() * 0.6 + 0.2,
        opacity:     Math.random() * 0.18 + 0.07,
        r, g, b,
    };
}

const bubbles = [];
for (let i = 0; i < 30; i++) bubbles.push(createBubble(true));

function drawBubble(b) {
    const { x, y, radius: R, r, g, b: bl, opacity } = b;

    ctx.save();

    // 1. Translucent body
    const bodyGrad = ctx.createRadialGradient(x, y, R * 0.1, x, y, R);
    bodyGrad.addColorStop(0,   `rgba(${r}, ${g}, ${bl}, ${opacity * 1.2})`);
    bodyGrad.addColorStop(0.6, `rgba(${r}, ${g}, ${bl}, ${opacity * 0.6})`);
    bodyGrad.addColorStop(1,   `rgba(${r}, ${g}, ${bl}, 0)`);
    ctx.beginPath();
    ctx.arc(x, y, R, 0, Math.PI * 2);
    ctx.fillStyle = bodyGrad;
    ctx.fill();

    // 2. Rim highlight
    ctx.beginPath();
    ctx.arc(x, y, R, 0, Math.PI * 2);
    ctx.strokeStyle = `rgba(255, 255, 255, ${opacity + 0.15})`;
    ctx.lineWidth = 1.2;
    ctx.stroke();

    // 3. Top gloss — elliptical highlight in upper-left
    ctx.save();
    ctx.beginPath();
    ctx.ellipse(x - R * 0.25, y - R * 0.35, R * 0.42, R * 0.22, -Math.PI / 5, 0, Math.PI * 2);
    const glossGrad = ctx.createRadialGradient(
        x - R * 0.25, y - R * 0.38, 0,
        x - R * 0.25, y - R * 0.35, R * 0.42
    );
    glossGrad.addColorStop(0,   'rgba(255, 255, 255, 0.75)');
    glossGrad.addColorStop(1,   'rgba(255, 255, 255, 0)');
    ctx.fillStyle = glossGrad;
    ctx.fill();
    ctx.restore();

    // 4. Bottom inner glow
    const bottomGrad = ctx.createRadialGradient(x, y + R * 0.6, 0, x, y + R * 0.6, R * 0.5);
    bottomGrad.addColorStop(0,   `rgba(${r}, ${g}, ${bl}, ${opacity * 0.5})`);
    bottomGrad.addColorStop(1,   'rgba(255, 255, 255, 0)');
    ctx.beginPath();
    ctx.arc(x, y, R, 0, Math.PI * 2);
    ctx.fillStyle = bottomGrad;
    ctx.fill();

    ctx.restore();
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    bubbles.forEach((b, i) => {
        b.wobble += b.wobbleSpeed;
        b.x += Math.sin(b.wobble) * b.wobbleAmp;
        b.y -= b.speed;

        if (b.y + b.radius < 0) {
            bubbles[i] = createBubble(false);
        }

        drawBubble(b);
    });

    requestAnimationFrame(draw);
}

draw();