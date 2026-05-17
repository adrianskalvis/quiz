<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $topic->name }} Questions</title>
    @vite(['resources/css/app.css', 'resources/css/pages/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header admin-header-row">
            <div>
                <h1>{{ $topic->icon }} {{ $topic->name }}</h1>
                <p>
                    {{ $questions->count() }} questions
                    @if($questions->count() < 15)
                        <span class="status-warning">— {{ 15 - $questions->count() }} more needed</span>
                    @else
                        <span class="status-ready">— minimum met ✓</span>
                    @endif
                </p>
            </div>
            <div class="admin-header-actions">
                <a href="{{ route('admin.topics.index') }}" class="btn-edit">← Topics</a>
                <a href="{{ route('admin.questions.create', $topic) }}" class="btn-primary">+ Add question</a>
            </div>
        </div>

        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif

        @forelse($questions as $i => $question)
            <div class="acard">
                <div class="acard-header">
                    <h2 class="question-title">
                        <span class="question-index">Q{{ $i + 1 }}.</span>
                        {{ $question->question_text }}
                    </h2>
                    <div class="row-actions">
                        <a href="{{ route('admin.questions.edit', [$topic, $question]) }}" class="btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.questions.destroy', [$topic, $question]) }}"
                              data-confirm="Delete this question?">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="answer-pill-list">
                    @foreach($question->answers as $answer)
                        <span class="answer-pill {{ $answer->is_correct ? 'is-correct' : '' }}">
                        @if($answer->is_correct)✓ @endif{{ $answer->answer_text }}
                    </span>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="admin-empty">
                <div class="admin-empty-icon">❓</div>
                No questions yet — add the first one!
            </div>
        @endforelse
    </main>
</div>
</body>
</html>
