<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — {{ $question ? 'Edit' : 'New' }} Question</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('admin.partials.style')
</head>
<body>
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

        <div class="acard" style="max-width:640px">
            <div class="acard-header">
                <h2>Question details</h2>
                <span style="font-size:11px;color:rgba(255,255,255,0.3)">
                    ● Select the correct answer with the radio button
                </span>
            </div>
            <div style="padding:20px">
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
                                        <button type="button" class="btn-danger remove-answer" style="padding:5px 9px;flex-shrink:0">✕</button>
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
                                        <button type="button" class="btn-danger remove-answer" style="padding:5px 9px;flex-shrink:0">✕</button>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <button type="button" class="add-answer-btn" id="addAnswer">+ Add another answer</button>
                    </div>

                    <div style="display:flex;gap:10px;margin-top:8px">
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
<script>
    let answerCount = document.querySelectorAll('.answer-row').length;

    document.getElementById('addAnswer').addEventListener('click', () => {
        const container = document.getElementById('answersContainer');
        const row = document.createElement('div');
        row.className = 'answer-row';
        row.innerHTML = `
        <input type="radio" name="correct_answer" class="answer-radio" value="${answerCount}">
        <input type="text" name="answers[]" class="form-input answer-input" placeholder="Answer option" required>
        <button type="button" class="btn-danger remove-answer" style="padding:5px 9px;flex-shrink:0">✕</button>
    `;
        container.appendChild(row);
        answerCount++;
        updateValues();
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-answer')) {
            if (document.querySelectorAll('.answer-row').length <= 2) return;
            e.target.closest('.answer-row').remove();
            updateValues();
        }
    });

    function updateValues() {
        document.querySelectorAll('.answer-row').forEach((row, i) => {
            row.querySelector('.answer-radio').value = i;
        });
    }
</script>
</body>
</html>
