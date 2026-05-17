<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $question ? 'Edit' : 'New' }} Question</title>
    @vite(['resources/css/app.css', 'resources/css/pages/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
<x-quiz-nav />
<div class="admin-page">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <div class="admin-header">
            <h1>{{ $question ? 'Edit question' : 'New question' }}</h1>
            <p>{{ $topic->icon }} {{ $topic->name }}</p>
        </div>

        @if($errors->any())
            <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

        <div class="acard acard-question-form">
            <div class="acard-header">
                <h2>Question details</h2>
                <span class="admin-muted-note">
                    ● Select the correct answer with the radio button
                </span>
            </div>
            <div class="acard-body">
                <form method="POST"
                      action="{{ $question
                          ? route('admin.questions.update', [$topic, $question])
                          : route('admin.questions.store', $topic) }}">
                    @csrf
                    @if($question) @method('PATCH') @endif

                    <div class="form-group">
                        <label class="form-label">Question text *</label>
                        <textarea name="question_text" class="form-textarea"
                                  placeholder="e.g. What is the chemical symbol for gold?"
                                  required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Answer options
                            <span class="correct-hint">— radio = correct answer</span>
                        </label>
                        <div id="answersContainer">
                            @if($question && $question->answers->count())
                                @foreach($question->answers as $i => $answer)
                                    <div class="answer-row">
                                        <input type="radio" name="correct_answer" class="answer-radio"
                                               value="{{ $i }}" {{ $answer->is_correct ? 'checked' : '' }}>
                                        <input type="text" name="answers[]" class="form-input answer-input"
                                               value="{{ old('answers.'.$i, $answer->answer_text) }}"
                                               placeholder="Answer option" required>
                                        <button type="button" class="btn-danger remove-answer answer-remove-btn">✕</button>
                                    </div>
                                @endforeach
                            @else
                                @for($i = 0; $i < 4; $i++)
                                    <div class="answer-row">
                                        <input type="radio" name="correct_answer" class="answer-radio"
                                               value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }}>
                                        <input type="text" name="answers[]" class="form-input answer-input"
                                               value="{{ old('answers.'.$i, '') }}"
                                               placeholder="Answer option {{ $i + 1 }}" required>
                                        <button type="button" class="btn-danger remove-answer answer-remove-btn">✕</button>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <button type="button" class="add-answer-btn" id="addAnswer">+ Add another answer</button>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            {{ $question ? 'Save changes' : 'Add question' }}
                        </button>
                        <a href="{{ route('admin.questions.index', $topic) }}" class="btn-edit">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
