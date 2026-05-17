    (function(){
        const quizForm = document.getElementById('quizForm');
        if (!quizForm) return;

        const total    = Number(quizForm.dataset.total || 0);
        const fill     = document.getElementById('progressFill');
        const currentQ = document.getElementById('currentQ');
        if (fill) fill.style.width = `${Number(fill.dataset.initialWidth || 0)}%`;

        function goTo(index) {
            // Hide all slides
            document.querySelectorAll('.question-slide').forEach(s => s.classList.add('is-hidden'));
            document.getElementById('slide-' + index).classList.remove('is-hidden');

            // Update progress bar
            fill.style.width = ((index + 1) / total * 100) + '%';
            currentQ.textContent = index + 1;


            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.querySelectorAll('.next-btn').forEach(btn => {
            btn.addEventListener('click', () => goTo(parseInt(btn.dataset.next)));
        });

        const rail = document.getElementById('quizBubbleRail');
        const scrollLeft = document.getElementById('quizScrollLeft');
        const scrollRight = document.getElementById('quizScrollRight');
        const allQuizesSection = document.getElementById('allQuizesSection');
        const allQuizesTab = document.getElementById('allQuizesTab');

        function isMobileQuizRail() {
            return window.matchMedia('(max-width: 720px)').matches;
        }

        function updateQuizScrollArrows() {
            if (!rail || !scrollLeft || !scrollRight) return;

            if (isMobileQuizRail()) {
                const maxScroll = rail.scrollHeight - rail.clientHeight;
                scrollLeft.classList.toggle('is-visible', rail.scrollTop > 4);
                scrollRight.classList.toggle('is-visible', rail.scrollTop < maxScroll - 4);
                return;
            }

            const maxScroll = rail.scrollWidth - rail.clientWidth;
            scrollLeft.classList.toggle('is-visible', rail.scrollLeft > 4);
            scrollRight.classList.toggle('is-visible', rail.scrollLeft < maxScroll - 4);
        }

        if (rail && scrollLeft && scrollRight) {
            scrollLeft.addEventListener('click', () => {
                if (isMobileQuizRail()) {
                    rail.scrollBy({ top: -rail.clientHeight * 0.75, behavior: 'smooth' });
                } else {
                    rail.scrollBy({ left: -rail.clientWidth * 0.75, behavior: 'smooth' });
                }
            });
            scrollRight.addEventListener('click', () => {
                if (isMobileQuizRail()) {
                    rail.scrollBy({ top: rail.clientHeight * 0.75, behavior: 'smooth' });
                } else {
                    rail.scrollBy({ left: rail.clientWidth * 0.75, behavior: 'smooth' });
                }
            });
            rail.addEventListener('scroll', updateQuizScrollArrows);
            window.addEventListener('resize', updateQuizScrollArrows);
            requestAnimationFrame(updateQuizScrollArrows);
        }

        if (allQuizesSection && allQuizesTab) {
            allQuizesTab.addEventListener('click', () => {
                allQuizesSection.classList.toggle('is-open');
                requestAnimationFrame(updateQuizScrollArrows);
            });
        }
    })();
