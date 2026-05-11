@props(['showGreeting' => true])

<header style="
    position: fixed; top: 0; left: 0; right: 0; z-index: 50;
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 28px;
    background: linear-gradient(180deg, rgba(190,215,238,0.18) 0%, rgba(165,198,225,0.1) 100%);
    border-bottom: 1px solid rgba(255,255,255,0.25);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    box-shadow: 0 1px 0 rgba(255,255,255,0.4) inset;
    font-family: 'Instrument Sans', sans-serif;
">
    {{-- Left: greeting (hidden during quiz) + back button --}}
    <div style="display:flex; align-items:center; gap:14px; min-width:180px;">
        @if($showGreeting)
            <div style="
                color: rgba(255,255,255,0.8);
                font-size: 13px;
                text-shadow: 0 1px 3px rgba(0,0,0,0.4);
                font-weight: 500;
                white-space: nowrap;
            ">
                Hello, <strong style="color:#fff">{{ Auth::user()->name }}</strong>
            </div>
        @endif

        <a href="{{ route('quizes') }}" style="
            position: relative;
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 1px 2px rgba(0,0,0,0.35);
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            overflow: hidden;
        "
        onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.borderColor='rgba(255,255,255,0.5)';this.style.transform='translateY(-1px)'"
        onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.3)';this.style.transform='translateY(0)'">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            All quizzes
        </a>
    </div>

    {{-- Center spacer (keeps right nav balanced) --}}
    <div></div>

    {{-- Right: nav --}}
    <nav style="display:flex; gap:8px; align-items:center;">
        <a href="{{ route('leaderboard') }}" style="
            position: relative;
            display: inline-block;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.85);
            letter-spacing: 0.02em;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            overflow: hidden;
        "
        onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.borderColor='rgba(255,255,255,0.5)';this.style.color='#fff';this.style.transform='translateY(-1px)'"
        onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='rgba(255,255,255,0.85)';this.style.transform='translateY(0)'">
            Leaderboard
        </a>

        <a href="{{ route('scores') }}" style="
            position: relative;
            display: inline-block;
            padding: 0.45rem 1.1rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.85);
            letter-spacing: 0.02em;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(6px);
            transition: all 0.15s ease;
            overflow: hidden;
        "
        onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.borderColor='rgba(255,255,255,0.5)';this.style.color='#fff';this.style.transform='translateY(-1px)'"
        onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='rgba(255,255,255,0.85)';this.style.transform='translateY(0)'">
            My scores
        </a>

        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" style="
                position: relative;
                display: inline-block;
                padding: 0.45rem 1.1rem;
                border-radius: 2rem;
                font-weight: 600;
                font-size: 0.8rem;
                color: rgba(255,255,255,0.85);
                letter-spacing: 0.02em;
                border: 1px solid rgba(255,255,255,0.3);
                background: rgba(255,255,255,0.1);
                backdrop-filter: blur(6px);
                transition: all 0.15s ease;
                overflow: hidden;
                cursor: pointer;
                font-family: 'Instrument Sans', sans-serif;
            "
            onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.borderColor='rgba(255,255,255,0.5)';this.style.color='#fff';this.style.transform='translateY(-1px)'"
            onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='rgba(255,255,255,0.85)';this.style.transform='translateY(0)'">
                Log out
            </button>
        </form>

        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.index') }}" style="color:rgba(255,205,100,0.9);font-size:12px;padding:4px 13px;border-radius:16px;border:0.5px solid rgba(255,200,80,0.35);background:rgba(255,200,60,0.08);text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='rgba(255,200,60,0.16)';this.style.color='#ffd060'"
               onmouseout="this.style.background='rgba(255,200,60,0.08)';this.style.color='rgba(255,205,100,0.9)'">
                Admin panel
            </a>
        @endif

    </nav>
</header>
