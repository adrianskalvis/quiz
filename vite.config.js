import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/pages/auth.css',
                'resources/css/pages/welcome-page.css',
                'resources/css/pages/quizes-page.css',
                'resources/css/pages/quiz-page.css',
                'resources/css/pages/quiz-result-page.css',
                'resources/css/pages/leaderboard-page.css',
                'resources/css/pages/scores-page.css',
                'resources/css/pages/admin.css',
                'resources/js/app.js',
                'resources/js/quizes.js',
            ],
            refresh: true,
        }),
    ],
});
