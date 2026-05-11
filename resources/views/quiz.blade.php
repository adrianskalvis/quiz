<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: sans-serif;
            min-height: 100vh;
            background: url('/images/welcomebg.jpg') center/cover no-repeat fixed;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: rgba(5, 18, 32, 0.55);
            z-index: 0;
        }

        .page {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 100px 20px 60px;
        }

        /* ── Card ── */
        .card {
            width: 100%;
            max-width: 680px;
            background: rgba(255,255,255,0.07);
            border: 0.5px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            overflow: hidden;
        }

        /* ── Card header ── */
        .card-header {
            padding: 28px 32px 20px;
            border-bottom: 0.5px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .topic-icon {
            font-size: 36px;
            display: block;
            margin-bottom: 6px;
        }
        .card-header h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 500;
            letter-spacing: -0.3px;
            text-shadow: 0 0 40px rgba(140,210,255,0.4);
        }

        /* ── Progress area ── */
        .progress-area {
            padding: 20px 32px 0;
        }
        .progress-label {
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            margin-bottom: 8px;
        }
        .progress-label strong {
            color: rgba(255,255,255,0.9);
        }

        /* Frutiger Aero progress bar */
        .progress-track {
            width: 100%;
            height: 18px;
            background: rgba(0,0,0,0.25);
            border-radius: 99px;
            border: 0.5px solid rgba(255,255,255,0.1);
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(180deg,
            rgba(255,255,255,0.55) 0%,
            rgba(80,180,255,0.9)  35%,
            rgba(30,120,220,1)    65%,
            rgba(60,160,255,0.8)  100%
            );
            box-shadow:
                0 0 8px rgba(80,180,255,0.7),
                inset 0 1px 0 rgba(255,255,255,0.6),
                inset 0 -1px 0 rgba(0,60,140,0.4);
            position: relative;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Gloss overlay on bar */
        .progress-fill::after {
            content: '';
            position: absolute;
            top: 1px; left: 4px; right: 4px;
            height: 45%;
            background: linear-gradient(180deg, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0) 100%);
            border-radius: 99px;
        }

        /* ── Question body ── */
        .question-body {
            padding: 24px 32px 28px;
        }
        .question-text {
            color: #fff;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .question-text strong {
            color: rgba(255,255,255,0.55);
            font-weight: 400;
            font-size: 13px;
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* ── Frutiger Aero answer bubbles ── */
        .answers {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 24px;
        }
        .answer-item label {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 18px;
            border-radius: 14px;
            cursor: pointer;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        /* Gloss sheen on each option */
        .answer-item label::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.09) 0%, rgba(255,255,255,0) 100%);
            border-radius: 14px 14px 0 0;
            pointer-events: none;
        }
        .answer-item label:hover {
            background: rgba(80,180,255,0.15);
            border-color: rgba(80,180,255,0.4);
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(40,140,255,0.15);
        }
        .answer-item input[type="radio"] {
            display: none;
        }
        .answer-item input[type="radio"]:checked + label {
            background: rgba(60,160,255,0.22);
            border-color: rgba(100,200,255,0.6);
            box-shadow:
                0 0 0 1px rgba(100,200,255,0.3),
                0 4px 24px rgba(40,140,255,0.2),
                inset 0 1px 0 rgba(255,255,255,0.15);
        }

        /* Custom radio dot */
        .radio-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.3);
            background: rgba(0,0,0,0.2);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.3), 0 1px 0 rgba(255,255,255,0.1);
        }
        .answer-item input[type="radio"]:checked + label .radio-dot {
            background: radial-gradient(circle at 40% 35%, rgba(160,220,255,1) 0%, rgba(60,160,255,1) 60%);
            border-color: rgba(180,230,255,0.8);
            box-shadow:
                0 0 8px rgba(80,180,255,0.8),
                inset 0 1px 0 rgba(255,255,255,0.5);
        }
        .radio-dot::after {
            content: '';
            width: 7px; height: 7px;
            border-radius: 50%;
            background: white;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .answer-item input[type="radio"]:checked + label .radio-dot::after {
            opacity: 1;
        }

        .answer-text {
            color: rgba(255,255,255,0.88);
            font-size: 14px;
            line-height: 1.4;
        }

        /* ── Submit button ── */
        .submit-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg,
            rgba(100,190,255,0.9) 0%,
            rgba(40,130,230,1)   40%,
            rgba(20,100,210,1)   60%,
            rgba(60,150,255,0.9) 100%
            );
            box-shadow:
                0 0 0 1px rgba(120,200,255,0.4),
                0 4px 20px rgba(40,120,220,0.4),
                inset 0 1px 0 rgba(255,255,255,0.35),
                inset 0 -1px 0 rgba(0,40,120,0.3);
            transition: all 0.2s;
        }
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0) 100%);
        }
        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow:
                0 0 0 1px rgba(140,210,255,0.5),
                0 8px 28px rgba(40,120,220,0.5),
                inset 0 1px 0 rgba(255,255,255,0.4),
                inset 0 -1px 0 rgba(0,40,120,0.3);
        }
        .submit-btn:active { transform: translateY(0); }

        /* ── Question nav dots ── */
        .nav-dots {
            display: flex;
            gap: 6px;
            justify-content: center;
            padding: 0 32px 24px;
        }
        .dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 0.5px solid rgba(255,255,255,0.15);
            transition: all 0.3s;
        }
        .dot.active {
            background: rgba(100,190,255,0.9);
            box-shadow: 0 0 6px rgba(80,180,255,0.7);
            width: 20px;
            border-radius: 4px;
        }
        .dot.done {
            background: rgba(80,200,120,0.7);
        }
    </style>
</head>
<body>
<x-quiz-nav />

<div class="page">
    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <span class="topic-icon">{{ $topic->icon }}</span>
            <h1>{{ $topic->name }} Quiz</h1>
        </div>

        {{-- Progress --}}
        <div class="progress-area">
            <div class="progress-label">
                Question <strong id="currentQ">1</strong> of <strong>{{ $questions->count() }}</strong>
            </div>
            <div class="progress-track">
                <div class="progress-fill" id="progressFill"
                     style="width: {{ (1 / $questions->count()) * 100 }}%">
                </div>
            </div>
        </div>

        {{-- Nav dots --}}
        <div class="nav-dots" id="navDots">
            @foreach($questions as $i => $q)
                <div class="dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></div>
            @endforeach
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('quiz.submit', $topic->slug) }}" id="quizForm">
            @csrf

            @foreach($questions as $i => $question)
                <div class="question-body question-slide"
                     id="slide-{{ $i }}"
                     style="{{ $i > 0 ? 'display:none' : '' }}">

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
</div>

<script>
    (function(){
        const total    = {{ $questions->count() }};
        const fill     = document.getElementById('progressFill');
        const currentQ = document.getElementById('currentQ');
        const dots     = document.querySelectorAll('.dot');

        function goTo(index) {
            // Hide all slides
            document.querySelectorAll('.question-slide').forEach(s => s.style.display = 'none');
            document.getElementById('slide-' + index).style.display = 'block';

            // Update progress bar
            fill.style.width = ((index + 1) / total * 100) + '%';
            currentQ.textContent = index + 1;

            // Update dots
            dots.forEach((d, i) => {
                d.classList.remove('active', 'done');
                if (i < index)  d.classList.add('done');
                if (i === index) d.classList.add('active');
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.querySelectorAll('.next-btn').forEach(btn => {
            btn.addEventListener('click', () => goTo(parseInt(btn.dataset.next)));
        });
    })();
</script>
</body>
</html>
