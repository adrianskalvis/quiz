<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $topic->name }} Questions</title>
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
                <h1>{{ $topic->icon }} {{ $topic->name }}</h1>
                <p>
                    {{ $questions->count() }} questions
                    @if($questions->count() < 15)
                        <span style="color:rgba(255,190,60,0.85)">— {{ 15 - $questions->count() }} more needed</span>
                    @else
                        <span style="color:rgba(80,220,130,0.85)">— minimum met ✓</span>
                    @endif
                </p>
            </div>
            <div style="display:flex;gap:8px">
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
                    <h2 style="font-size:13px;color:rgba(255,255,255,0.8);font-weight:400;line-height:1.5">
                        <span style="color:rgba(255,255,255,0.3);margin-right:6px">Q{{ $i + 1 }}.</span>
                        {{ $question->question_text }}
                    </h2>
                    <div style="display:flex;gap:6px;flex-shrink:0;margin-left:12px">
                        <a href="{{ route('admin.questions.edit', [$topic, $question]) }}" class="btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.questions.destroy', [$topic, $question]) }}"
                              onsubmit="return confirm('Delete this question?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <div style="padding:12px 16px;display:flex;flex-wrap:wrap;gap:8px">
                    @foreach($question->answers as $answer)
                        <span style="
                        font-size:12px;padding:4px 12px;border-radius:99px;
                        background:{{ $answer->is_correct ? 'rgba(40,180,90,0.15)' : 'rgba(255,255,255,0.05)' }};
                        border:0.5px solid {{ $answer->is_correct ? 'rgba(40,180,90,0.4)' : 'rgba(255,255,255,0.1)' }};
                        color:{{ $answer->is_correct ? 'rgba(80,220,130,0.95)' : 'rgba(255,255,255,0.5)' }};
                    ">
                        @if($answer->is_correct)✓ @endif{{ $answer->answer_text }}
                    </span>
                    @endforeach
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:56px;color:rgba(255,255,255,0.25)">
                <div style="font-size:36px;margin-bottom:12px">❓</div>
                No questions yet — add the first one!
            </div>
        @endforelse
    </main>
</div>
</body>
</html>
