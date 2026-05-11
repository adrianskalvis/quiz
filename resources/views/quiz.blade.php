<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->name }} Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Instrument Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: url('/images/welcomebg.jpg') center/cover no-repeat fixed;
        }

        .screen {
            width: 100%; height: 100vh;
            position: relative; overflow: hidden;
        }


        /* ── Aero Nav Buttons ── */
        .aero-btn {
            position: relative;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Instrument Sans', sans-serif;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 1px 2px rgba(0,0,0,0.35);
            border: 1px solid rgba(255,255,255,0.55);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.55) 0%, rgba(255,255,255,0.15) 48%, rgba(100,200,255,0.25) 50%, rgba(60,160,255,0.45) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.7) 0%, rgba(30,120,230,0.85) 100%);
            box-shadow: 0 2px 8px rgba(0,100,255,0.35), 0 1px 0 rgba(255,255,255,0.6) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            overflow: hidden;
            display: inline-block;
            cursor: pointer;
        }
        .aero-btn::before {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.75) 0%, rgba(255,255,255,0.1) 100%);
            pointer-events: none;
        }
        .aero-btn:hover {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.65) 0%, rgba(255,255,255,0.2) 48%, rgba(120,215,255,0.3) 50%, rgba(80,180,255,0.55) 100%),
                linear-gradient(180deg, rgba(100,190,255,0.8) 0%, rgba(40,140,255,0.9) 100%);
            box-shadow: 0 4px 16px rgba(0,120,255,0.5), 0 1px 0 rgba(255,255,255,0.7) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            transform: translateY(-1px);
        }
        .aero-btn:active {
            transform: translateY(0px);
            box-shadow: 0 1px 4px rgba(0,100,255,0.3), 0 1px 0 rgba(255,255,255,0.5) inset;
        }

        /* Aero ghost button */
        .aero-btn-ghost {
            position: relative;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Instrument Sans', sans-serif;
            color: rgba(255,255,255,0.85);
            letter-spacing: 0.02em;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            display: inline-block;
            cursor: pointer;
            overflow: hidden;
        }
        .aero-btn-ghost::before {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.35) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
        }
        .aero-btn-ghost:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            color: #fff;
            transform: translateY(-1px);
        }
        .aero-btn-ghost:active { transform: translateY(0); }

        /* ── Top bar ── */
        .topbar {
            position: absolute; top: 0; left: 0; right: 0; z-index: 20;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 28px;
            background: linear-gradient(180deg, rgba(190,215,238,0.18) 0%, rgba(165,198,225,0.1) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 1px 0 rgba(255,255,255,0.4) inset;
        }

        .hello {
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.4);
        }
        .hello strong { color: #fff; }

        .nav { display: flex; gap: 8px; align-items: center; }

        /* ── Scrollable content below topbar ── */
        .page {
            position: absolute;
            top: 57px; left: 0; right: 0; bottom: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
        }

        /* ── Card ── */
        .card {
            width: 100%;
            max-width: 680px;
            background: linear-gradient(160deg, rgba(200,220,240,0.1) 0%, rgba(180,205,228,0.07) 100%);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 12px 40px rgba(0,30,80,0.3), 0 1px 0 rgba(255,255,255,0.25) inset;
            overflow: hidden;
        }

        /* ── Card header ── */
        .card-header {
            padding: 28px 32px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            text-align: center;
            background: linear-gradient(180deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);
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
            text-shadow: 0 0 40px rgba(140,210,255,0.5), 0 2px 6px rgba(0,0,0,0.4);
        }

        /* ── Progress area ── */
        .progress-area {
            padding: 20px 32px 0;
        }
        .progress-label {
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.03em;
            margin-bottom: 8px;
            text-shadow: 0 1px 6px rgba(0,0,0,0.8), 0 0 20px rgba(0,0,0,0.6);
        }
        .progress-label strong { color: #fff; }

        .progress-track {
            width: 100%;
            height: 14px;
            background: rgba(0,0,0,0.3);
            border-radius: 99px;
            border: 1px solid rgba(255,255,255,0.1);
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.4);
        }
        .progress-fill {
            height: 100%;
            border-radius: 99px;
            background:
                linear-gradient(180deg,
                    rgba(255,255,255,0.55) 0%,
                    rgba(80,180,255,0.9)   35%,
                    rgba(30,120,220,1)     65%,
                    rgba(60,160,255,0.8)   100%
                );
            box-shadow: 0 0 8px rgba(80,180,255,0.7), inset 0 1px 0 rgba(255,255,255,0.6);
            position: relative;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .progress-fill::after {
            content: '';
            position: absolute;
            top: 1px; left: 4px; right: 4px;
            height: 45%;
            background: linear-gradient(180deg, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0) 100%);
            border-radius: 99px;
        }

        /* ── Nav dots ── */
        .nav-dots {
            display: flex;
            gap: 6px;
            justify-content: center;
            padding: 16px 32px;
        }
        .dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.3s;
        }
        .dot.active {
            background:
                linear-gradient(180deg, rgba(100,200,255,0.9) 0%, rgba(40,140,230,1) 100%);
            box-shadow: 0 0 6px rgba(80,180,255,0.8), inset 0 1px 0 rgba(255,255,255,0.4);
            width: 22px;
            border-radius: 4px;
            border-color: rgba(140,210,255,0.5);
        }
        .dot.done {
            background: linear-gradient(180deg, rgba(100,220,140,0.9) 0%, rgba(40,170,90,1) 100%);
            box-shadow: 0 0 5px rgba(60,200,100,0.6);
            border-color: rgba(120,220,150,0.5);
        }

        /* ── Question body ── */
        .question-body {
            padding: 8px 32px 28px;
        }
        .question-text {
            color: #fff;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            text-shadow: 0 1px 8px rgba(0,0,0,0.9), 0 0 30px rgba(0,0,0,0.7);
        }
        .question-text strong {
            color: rgba(255,255,255,0.8);
            font-weight: 600;
            font-size: 10px;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            text-shadow: 0 1px 6px rgba(0,0,0,0.9);
        }

        /* ── Answer options ── */
        .answers {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }
        .answer-item label {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.15s ease;
            position: relative;
            overflow: hidden;
        }
        .answer-item label::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 100%);
            border-radius: 12px 12px 0 0;
            pointer-events: none;
        }
        .answer-item label:hover {
            background: rgba(80,170,255,0.14);
            border-color: rgba(80,180,255,0.4);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(40,140,255,0.15), 0 1px 0 rgba(255,255,255,0.1) inset;
        }
        .answer-item input[type="radio"] { display: none; }
        .answer-item input[type="radio"]:checked + label {
            background: rgba(60,160,255,0.2);
            border-color: rgba(100,200,255,0.55);
            box-shadow:
                0 0 0 1px rgba(100,200,255,0.25),
                0 4px 20px rgba(40,140,255,0.18),
                inset 0 1px 0 rgba(255,255,255,0.12);
        }

        .radio-dot {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.25);
            background: rgba(0,0,0,0.25);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.4);
        }
        .answer-item input[type="radio"]:checked + label .radio-dot {
            background: radial-gradient(circle at 40% 35%, rgba(160,220,255,1) 0%, rgba(50,150,255,1) 60%);
            border-color: rgba(160,220,255,0.8);
            box-shadow: 0 0 8px rgba(80,180,255,0.8), inset 0 1px 0 rgba(255,255,255,0.5);
        }
        .radio-dot::after {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #fff;
            opacity: 0;
            transition: opacity 0.15s;
        }
        .answer-item input[type="radio"]:checked + label .radio-dot::after { opacity: 1; }

        .answer-text {
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.4;
            text-shadow: 0 1px 5px rgba(0,0,0,0.8);
        }

        /* ── Submit / Next button — matches .aero-btn full-width ── */
        .submit-btn {
            position: relative;
            width: 100%;
            padding: 0.65rem 1.4rem;
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.55);
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Instrument Sans', sans-serif;
            letter-spacing: 0.02em;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.35);
            cursor: pointer;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.55) 0%, rgba(255,255,255,0.15) 48%, rgba(100,200,255,0.25) 50%, rgba(60,160,255,0.45) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.7) 0%, rgba(30,120,230,0.85) 100%);
            box-shadow: 0 2px 8px rgba(0,100,255,0.35), 0 1px 0 rgba(255,255,255,0.6) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: all 0.15s ease;
        }
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0; left: 5%; right: 5%;
            height: 48%;
            border-radius: 2rem 2rem 50% 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.75) 0%, rgba(255,255,255,0.1) 100%);
            pointer-events: none;
        }
        .submit-btn:hover {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.65) 0%, rgba(255,255,255,0.2) 48%, rgba(120,215,255,0.3) 50%, rgba(80,180,255,0.55) 100%),
                linear-gradient(180deg, rgba(100,190,255,0.8) 0%, rgba(40,140,255,0.9) 100%);
            box-shadow: 0 4px 16px rgba(0,120,255,0.5), 0 1px 0 rgba(255,255,255,0.7) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            transform: translateY(-1px);
        }
        .submit-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 4px rgba(0,100,255,0.3), 0 1px 0 rgba(255,255,255,0.5) inset;
        }
    </style>
</head>
<body>
<div class="screen">

    {{-- ── Top bar (matches quizes.blade.php) ── --}}
    <div class="topbar">
        <a href="{{ route('quizes') }}" class="aero-btn-ghost">← All quizzes</a>

        <div></div>

        <nav class="nav">
            @if(Auth::user()->is_admin ?? false)
                <a href="{{ route('admin.dashboard') }}" class="aero-btn" style="
                    background:
                        linear-gradient(180deg,rgba(255,255,255,0.5) 0%,rgba(255,255,255,0.12) 48%,rgba(255,200,60,0.3) 50%,rgba(220,160,0,0.55) 100%),
                        linear-gradient(180deg,rgba(255,200,80,0.75) 0%,rgba(200,140,0,0.9) 100%);
                    box-shadow:0 2px 8px rgba(200,140,0,0.4),0 1px 0 rgba(255,255,255,0.6) inset;
                ">Admin</a>
            @endif
            <a href="{{ route('leaderboard') }}" class="aero-btn-ghost">Leaderboard</a>
            <a href="{{ route('scores') }}" class="aero-btn-ghost">My scores</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="aero-btn-ghost">Log out</button>
            </form>
        </nav>
    </div>

    {{-- ── Scrollable quiz content ── --}}
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
                            <strong>Question {{ $i + 1 }}</strong>
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

</div>

<script>
    (function(){
        const total    = {{ $questions->count() }};
        const fill     = document.getElementById('progressFill');
        const currentQ = document.getElementById('currentQ');
        const dots     = document.querySelectorAll('.dot');

        function goTo(index) {
            document.querySelectorAll('.question-slide').forEach(s => s.style.display = 'none');
            document.getElementById('slide-' + index).style.display = 'block';

            fill.style.width = ((index + 1) / total * 100) + '%';
            currentQ.textContent = index + 1;

            dots.forEach((d, i) => {
                d.classList.remove('active', 'done');
                if (i < index)  d.classList.add('done');
                if (i === index) d.classList.add('active');
            });

            // Scroll the inner .page div back to top
            document.querySelector('.page').scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.querySelectorAll('.next-btn').forEach(btn => {
            btn.addEventListener('click', () => goTo(parseInt(btn.dataset.next)));
        });
    })();
</script>
</body>
</html>