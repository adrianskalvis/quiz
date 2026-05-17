@props(['showGreeting' => true, 'showBackButton' => true])



<header class="quiz-top-nav">
    {{-- Left: greeting --}}
    <div class="quiz-top-nav-greeting">
        @if($showGreeting)
            Hello, <strong>{{ Auth::user()->name }}</strong>
        @endif
    </div>

    {{-- Center spacer --}}
    <div></div>

    {{-- Right: nav --}}
    <nav class="quiz-top-nav-links">
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.index') }}" class="aero-btn aero-btn-admin">Admin</a>
        @endif
        @if($showBackButton)
            <a href="{{ route('quizes') }}" class="aero-btn-ghost"><span>All</span><span class="mobile-break">Quizes</span></a>
        @endif
        <a href="{{ route('leaderboard') }}" class="aero-btn-ghost"><span>Leader</span><span class="mobile-break">Board</span></a>
        <a href="{{ route('scores') }}" class="aero-btn-ghost"><span>My</span><span class="mobile-break">scores</span></a>
            <a href="{{ route('welcome') }}" class="aero-btn-ghost">Home</a>
        <form method="POST" action="{{ route('logout') }}" class="quiz-top-nav-form">
            @csrf
            <button type="submit" class="aero-btn-ghost">Log out</button>
        </form>
    </nav>
</header>

<x-side-music-player />
