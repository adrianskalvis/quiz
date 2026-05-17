<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} Quiz</title>
    @vite(['resources/css/app.css', 'resources/css/pages/quiz-page.css', 'resources/js/app.js'])
    
</head>
<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <img
                src="{{ $topic->image ? \Illuminate\Support\Facades\Storage::url($topic->image) : asset('images/appicon.jpg') }}"
                alt="{{ $topic->name }} icon"
                class="topic-icon"
            >
            <h1>{{ $topic->name }} Quiz</h1>
        </div>

        {{-- Progress --}}
        <div class="progress-area">
            <div class="progress-label">
                Question <strong id="currentQ">1</strong> of <strong>{{ $questions->count() }}</strong>
            </div>
            <div class="progress-track">
                <div class="progress-fill" id="progressFill"
                     data-initial-width="{{ (1 / $questions->count()) * 100 }}">
                </div>
            </div>
        </div>


        {{-- Form --}}
        <form method="POST" action="{{ route('quiz.submit', $topic->slug) }}" id="quizForm" data-total="{{ $questions->count() }}">
            @csrf

            @foreach($questions as $i => $question)
                <div class="question-body question-slide {{ $i > 0 ? 'is-hidden' : '' }}"
                     id="slide-{{ $i }}">

                    <div class="question-text">
                        <strong>Question</strong>
                        {{ $question->question_text }}
                    </div>

                    <ul class="answers">
                        @foreach($question->answers as $answer)
                            <li class="answer-item">
                                <input type="radio"
                                       name="answer_{{ $question->id }}"
                                       id="a{{ $answer->id }}"
                                       value="{{ $answer->id }}">
                                <label for="a{{ $answer->id }}">
                                    <span class="radio-dot"></span>
                                    <span class="answer-text">{{ $answer->answer_text }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Next / Submit --}}
                    @if($i < $questions->count() - 1)
                        <button type="button" class="submit-btn next-btn" data-next="{{ $i + 1 }}">
                            Next question →
                        </button>
                    @else
                        <button type="submit" class="submit-btn">
                            Submit quiz
                        </button>
                    @endif
                </div>
            @endforeach
        </form>

    </div>

    <section class="all-quizes-section" id="allQuizesSection" aria-label="All quizes">
        <button type="button" class="all-quizes-tab" id="allQuizesTab" aria-label="Toggle all quizes">
            <span>All quizes</span>
        </button>
        <h2>All quizes</h2>
        <div class="quiz-bubble-rail-wrap">
            <button type="button" class="quiz-scroll-arrow quiz-scroll-arrow--left" id="quizScrollLeft" aria-label="Scroll left">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M8.8 3.2L5 7L8.8 10.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="quiz-bubble-rail" id="quizBubbleRail">
                @foreach($topicsJson as $topicItem)
                    <a
                        href="{{ $topicItem['url'] }}"
                        class="quiz-bubble-link {{ $topicItem['slug'] === $topic->slug ? 'is-current' : '' }}"
                    >
                        <img src="{{ $topicItem['image'] }}" alt="{{ $topicItem['label'] }} icon" class="quiz-bubble-icon" draggable="false">
                        <span class="quiz-bubble-name">{{ $topicItem['label'] }}</span>
                    </a>
                @endforeach
            </div>
            <button type="button" class="quiz-scroll-arrow quiz-scroll-arrow--right" id="quizScrollRight" aria-label="Scroll right">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M5.2 3.2L9 7L5.2 10.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </section>
</div>


</body>
</html>
