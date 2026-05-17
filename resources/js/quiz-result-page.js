    (function(){
        const root = document.getElementById('quizResultPage');
        if (!root) return;

        const percentage = Number(root.dataset.percentage || 0);
        const circumference = 2 * Math.PI * 65; // 408.4

        // Animate ring
        const ring = document.getElementById('ringFill');
        ring.style.strokeDasharray  = circumference;
        ring.style.strokeDashoffset = circumference;

        // Animate percentage counter
        const pctEl = document.getElementById('pctCount');
        const bar   = document.getElementById('scoreBar');

        // Trigger after paint
        requestAnimationFrame(() => {
            setTimeout(() => {
                // Ring
                const offset = circumference - (percentage / 100) * circumference;
                ring.style.strokeDashoffset = offset;

                // Bar
                bar.style.width = percentage + '%';

                // Count up number
                let current = 0;
                const step  = Math.ceil(percentage / 60);
                const timer = setInterval(() => {
                    current = Math.min(current + step, percentage);
                    pctEl.innerHTML = current + '<span class="ring-pct-sym">%</span>';
                    if (current >= percentage) clearInterval(timer);
                }, 24);
            }, 120);
        });
    })();
