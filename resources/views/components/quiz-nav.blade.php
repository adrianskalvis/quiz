<header style="
    position:fixed;top:0;left:0;right:0;z-index:50;
    display:flex;align-items:center;justify-content:space-between;
    padding:13px 28px;
    background:rgba(255,255,255,0.07);
    border-bottom:0.5px solid rgba(255,255,255,0.13);
    backdrop-filter:blur(14px);
">
    <a href="{{ route('quizes') }}" style="
        display:flex;align-items:center;gap:8px;
        color:rgba(255,255,255,0.75);font-size:13px;text-decoration:none;
        transition:color .2s;
    " onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.75)'">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        All quizzes
    </a>

    <div style="color:rgba(255,255,255,0.8);font-size:13px;">
        Hello, <strong style="color:#fff">{{ Auth::user()->name }}</strong>
    </div>

    <nav style="display:flex;gap:8px;align-items:center;">
        <a href="{{ route('leaderboard') }}" style="color:rgba(255,255,255,0.6);font-size:12px;padding:4px 13px;border-radius:16px;border:0.5px solid rgba(255,255,255,0.18);background:rgba(255,255,255,0.07);text-decoration:none;transition:all .2s;"
           onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='#fff'"
           onmouseout="this.style.background='rgba(255,255,255,0.07)';this.style.color='rgba(255,255,255,0.6)'">
            Leaderboard
        </a>
        <a href="{{ route('scores') }}" style="color:rgba(255,255,255,0.6);font-size:12px;padding:4px 13px;border-radius:16px;border:0.5px solid rgba(255,255,255,0.18);background:rgba(255,255,255,0.07);text-decoration:none;transition:all .2s;"
           onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='#fff'"
           onmouseout="this.style.background='rgba(255,255,255,0.07)';this.style.color='rgba(255,255,255,0.6)'">
            My scores
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" style="color:rgba(255,255,255,0.6);font-size:12px;padding:4px 13px;border-radius:16px;border:0.5px solid rgba(255,255,255,0.18);background:rgba(255,255,255,0.07);cursor:pointer;font-family:inherit;transition:all .2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='#fff'"
                    onmouseout="this.style.background='rgba(255,255,255,0.07)';this.style.color='rgba(255,255,255,0.6)'">
                Log out
            </button>
        </form>
    </nav>
</header>
