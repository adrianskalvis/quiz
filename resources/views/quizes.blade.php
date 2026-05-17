<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Quiz</title>
    @vite(['resources/css/app.css', 'resources/css/pages/quizes-page.css', 'resources/js/app.js', 'resources/js/quizes.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
</head>
<body>
<div class="screen">

    <!-- Aero top bar -->
    <div class="topbar">
        <!-- Left: greeting -->
        <div class="hello">Hello, <strong>{{ Auth::user()->name }}</strong></div>

        <!-- Center spacer -->
        <div></div>

        <!-- Right: nav -->
        <nav class="nav">
            @if(Auth::user()->is_admin ?? false)
                <a href="{{ route('admin.index') }}" class="aero-btn aero-btn-admin">Admin</a>
            @endif
            <a href="{{ route('leaderboard') }}" class="aero-btn-ghost"><span>Leader</span><span class="mobile-break">Board</span></a>
            <a href="{{ route('scores') }}" class="aero-btn-ghost"><span>My</span><span class="mobile-break">scores</span></a>
                <a href="{{ route('welcome') }}" class="aero-btn-ghost">Home</a>
            <form method="POST" action="{{ route('logout') }}" class="nav-form">
                @csrf
                <button type="submit" class="aero-btn-ghost">Log out</button>
            </form>
        </nav>
    </div>

    <!-- Center UI -->
    <div class="center-ui">
        <div class="title-row" id="titleRow">
            <h1>Select quiz</h1>
            <div class="arrow-pill" id="arrowPill">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                    <path d="M2 3.5L5 6.5L8 3.5" stroke="rgba(255,255,255,0.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="subtitle">Click a bubble to start &middot; {{ $topics->count() }} topics available</div>
        <div class="filter-panel" id="filterPanel">
            @foreach($topics as $topic)
                <button class="fbtn" data-filter="{{ $topic->slug }}">{{ $topic->name }}</button>
            @endforeach
            <button class="fbtn" data-filter="all">All quizes</button>
        </div>
    </div>

    <canvas id="bubbleCanvas" data-topics='@json($topicsJson)'></canvas>
</div>

<x-side-music-player />
</body>
</html>
