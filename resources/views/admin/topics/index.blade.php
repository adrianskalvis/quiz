<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Topics</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('admin.partials.style')
</head>
<body>
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header" style="display:flex;justify-content:space-between;align-items:flex-start">
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
                            <div style="display:flex;align-items:center;gap:10px;">
                                @if($topic->image)
                                    <img src="{{ Storage::url($topic->image) }}"
                                         style="width:32px;height:32px;border-radius:8px;object-fit:cover;border:0.5px solid rgba(255,255,255,0.1);">
                                @else
                                    <span style="font-size:22px;line-height:1">{{ $topic->icon ?? '📝' }}</span>
                                @endif
                                <div>
                                    <div style="color:#fff;font-weight:500">{{ $topic->name }}</div>
                                    <div style="font-size:10px;color:rgba(255,255,255,0.3)">{{ $topic->color }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:rgba(255,255,255,0.4);font-size:12px;font-family:monospace">{{ $topic->slug }}</td>
                        <td>
                            <span style="color:{{ $topic->questions_count >= 15 ? 'rgba(80,220,130,0.85)' : 'rgba(255,190,60,0.85)' }};font-weight:500">
                                {{ $topic->questions_count }}
                            </span>
                            <span style="color:rgba(255,255,255,0.25);font-size:11px">/ 15 min</span>
                        </td>
                        <td>
                            @if($topic->questions_count >= 15)
                                <span style="font-size:11px;color:rgba(80,220,130,0.8)">✓ Ready</span>
                            @else
                                <span style="font-size:11px;color:rgba(255,190,60,0.8)">⚠ Needs {{ 15 - $topic->questions_count }} more</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                <a href="{{ route('admin.questions.index', $topic) }}" class="btn-primary" style="padding:5px 11px;font-size:11px">
                                    Questions
                                </a>
                                <a href="{{ route('admin.topics.edit', $topic) }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.topics.destroy', $topic) }}"
                                      onsubmit="return confirm('Delete {{ addslashes($topic->name) }} and ALL its questions?')">
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
