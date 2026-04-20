import '../css/welcome.css';

const canvas = document.getElementById('bubble-canvas');
const ctx = canvas.getContext('2d');

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

const bubbles = [];

function createBubble() {
    return {
        x: Math.random() * canvas.width,
        y: canvas.height + Math.random() * 100,
        radius: Math.random() * 40 + 10,
        speed: Math.random() * 1.5 + 0.5,
        opacity: Math.random() * 0.2 + 0.05,
        drift: (Math.random() - 0.5) * 0.5,
    };
}

for (let i = 0; i < 25; i++) {
    const b = createBubble();
    b.y = Math.random() * canvas.height;
    bubbles.push(b);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    bubbles.forEach((b, i) => {
        ctx.beginPath();
        ctx.arc(b.x, b.y, b.radius, 0, Math.PI * 2);
        ctx.strokeStyle = `rgba(255, 255, 255, ${b.opacity + 0.1})`;
        ctx.lineWidth = 1.5;
        ctx.stroke();
        ctx.fillStyle = `rgba(255, 255, 255, ${b.opacity})`;
        ctx.fill();

        b.y -= b.speed;
        b.x += b.drift;

        if (b.y + b.radius < 0) {
            bubbles[i] = createBubble();
        }
    });

    requestAnimationFrame(draw);
}

draw();