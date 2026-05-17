<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Topics</title>
    @vite(['resources/css/app.css', 'resources/css/pages/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header admin-header-row">
            <div>
                <h1>Topics & Questions</h1>
                <p>Create and manage quiz topics</p>
            </div>
            <a href="{{ route('admin.topics.create') }}" class="btn-primary">+ New topic</a>
        </div>

        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif

        <div class="acard">
            <table class="atable">
                <thead>
                <tr>
                    <th>Topic</th>
                    <th>Slug</th>
                    <th>Questions</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>
                            <div class="topic-cell">
                                @if($topic->image)
                                    <img src="{{ Storage::url($topic->image) }}"
                                         class="topic-thumb" alt="{{ $topic->name }} image">
                                @else
                                    <span class="topic-emoji">{{ $topic->icon ?? '📝' }}</span>
                                @endif
                                <div>
                                    <div class="topic-name">{{ $topic->name }}</div>
                                    <div class="topic-color">{{ $topic->color }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="mono-muted">{{ $topic->slug }}</td>
                        <td>
                            <span class="{{ $topic->questions_count >= 15 ? 'status-ready' : 'status-warning' }}">
                                {{ $topic->questions_count }}
                            </span>
                            <span class="minimum-note">/ 15 min</span>
                        </td>
                        <td>
                            @if($topic->questions_count >= 15)
                                <span class="status-label status-ready">✓ Ready</span>
                            @else
                                <span class="status-label status-warning">⚠ Needs {{ 15 - $topic->questions_count }} more</span>
                            @endif
                        </td>
                        <td>
                            <div class="row-actions wrap">
                                <a href="{{ route('admin.questions.index', $topic) }}" class="btn-primary btn-compact">
                                    Questions
                                </a>
                                <a href="{{ route('admin.topics.edit', $topic) }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.topics.destroy', $topic) }}"
                                      data-confirm="Delete {{ addslashes($topic->name) }} and ALL its questions?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
