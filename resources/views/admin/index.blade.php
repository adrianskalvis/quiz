<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/css/pages/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <p>Here's an overview of your quiz application</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-val">{{ $stats['users'] }}</div>
                <div class="stat-lbl">Total users</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-val">{{ $stats['topics'] }}</div>
                <div class="stat-lbl">Topics</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">❓</div>
                <div class="stat-val">{{ $stats['questions'] }}</div>
                <div class="stat-lbl">Questions</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-val">{{ $stats['attempts'] }}</div>
                <div class="stat-lbl">Quiz attempts</div>
            </div>
        </div>

        <div class="quick-links">
            <a href="{{ route('admin.users.index') }}"  class="ql-btn">👥 Manage users →</a>
            <a href="{{ route('admin.topics.index') }}" class="ql-btn">📚 Manage topics →</a>
        </div>
    </main>
</div>
</body>
</html>
