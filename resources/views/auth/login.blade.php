<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} — Log in</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0; padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('/images/welcomebg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Instrument Sans', 'Segoe UI', Tahoma, sans-serif;
        }

        /* ── Glass login card ── */
        .login-card {
            width: 420px;
            border-radius: 12px;
            background: linear-gradient(160deg, rgba(200,220,240,0.82) 0%, rgba(180,205,228,0.75) 100%);
            border: 1.5px solid rgba(255,255,255,0.85);
            box-shadow: 0 12px 40px rgba(80,130,180,0.35),
                        0 1.5px 0 rgba(255,255,255,0.9) inset,
                        0 -1px 0 rgba(160,190,215,0.3) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            overflow: hidden;
        }

        /* Title bar */
        .card-titlebar {
            background: linear-gradient(180deg, rgba(190,215,238,0.95) 0%, rgba(165,198,225,0.9) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.7);
            padding: 7px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title-text {
            font-size: 11px;
            font-weight: 700;
            color: #4a6d8c;
            text-shadow: 0 1px 0 rgba(255,255,255,0.8);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .card-dots { display: flex; gap: 4px; }
        .card-dot {
            width: 12px; height: 12px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.6);
        }
        .dot-close { background: linear-gradient(135deg, #ff9090, #dd5555); }
        .dot-min   { background: linear-gradient(135deg, #ffe080, #ccaa33); }
        .dot-max   { background: linear-gradient(135deg, #90dd90, #44aa44); }

        /* Card body */
        .card-body { padding: 24px 28px 28px; }

        /* Welcome header */
        .card-heading {
            text-align: center;
            margin-bottom: 22px;
        }
        .card-heading h1 {
            font-size: 20px;
            font-weight: 700;
            color: #2c4f6e;
            text-shadow: 0 1px 0 rgba(255,255,255,0.7);
            margin: 0 0 4px;
            letter-spacing: 0.03em;
        }
        .card-heading p {
            font-size: 12px;
            color: #5a7e9e;
            margin: 0;
            letter-spacing: 0.04em;
        }

        /* Session status */
        .session-status {
            margin-bottom: 14px;
            padding: 8px 12px;
            border-radius: 6px;
            background: rgba(80,200,120,0.18);
            border: 1px solid rgba(80,200,120,0.4);
            font-size: 12px;
            color: #2a7a4a;
        }

        /* Labels */
        .field-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #3d6080;
            text-shadow: 0 1px 0 rgba(255,255,255,0.6);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        /* Inputs */
        .field-input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 7px;
            border: 1px solid rgba(140,190,225,0.6);
            background: linear-gradient(180deg, rgba(230,242,252,0.75) 0%, rgba(210,230,248,0.6) 100%);
            box-shadow: inset 0 2px 5px rgba(80,130,180,0.12), 0 1px 0 rgba(255,255,255,0.8);
            font-size: 13px;
            color: #2c4a65;
            outline: none;
            font-family: inherit;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field-input:focus {
            border-color: rgba(80,160,230,0.75);
            box-shadow: inset 0 2px 5px rgba(80,130,180,0.12), 0 0 0 3px rgba(80,160,230,0.2);
        }
        .field-input::placeholder { color: #8fb0cc; }

        .field-error {
            margin-top: 4px;
            font-size: 11px;
            color: #cc4444;
        }

        .field-group { margin-bottom: 16px; }

        /* Remember me checkbox */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .remember-row input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #4a90d9;
            cursor: pointer;
        }
        .remember-row label {
            font-size: 12px;
            color: #4a6d8c;
            cursor: pointer;
            user-select: none;
        }

        /* Bottom row */
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .forgot-link {
            font-size: 11px;
            color: #5a7e9e;
            text-decoration: underline;
            text-underline-offset: 2px;
            transition: color 0.15s;
        }
        .forgot-link:hover { color: #2c4f6e; }

        /* Aero submit button */
        .aero-btn {
            position: relative;
            padding: 0.55rem 1.4rem;
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.55);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.55) 0%, rgba(255,255,255,0.15) 48%, rgba(100,200,255,0.25) 50%, rgba(60,160,255,0.45) 100%),
                linear-gradient(180deg, rgba(80,170,255,0.7) 0%, rgba(30,120,230,0.85) 100%);
            box-shadow: 0 2px 8px rgba(0,100,255,0.35), 0 1px 0 rgba(255,255,255,0.6) inset, 0 -1px 0 rgba(0,80,200,0.3) inset;
            backdrop-filter: blur(6px);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            letter-spacing: 0.04em;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            cursor: pointer;
            overflow: hidden;
            transition: all 0.15s ease;
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
            box-shadow: 0 4px 16px rgba(0,120,255,0.5), 0 1px 0 rgba(255,255,255,0.7) inset;
            transform: translateY(-1px);
        }
        .aero-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 4px rgba(0,100,255,0.3);
        }

        /* Divider + register link */
        .card-register {
            margin-top: 18px;
            text-align: center;
            font-size: 12px;
            color: #5a7e9e;
            border-top: 1px solid rgba(150,190,220,0.35);
            padding-top: 16px;
        }
        .card-register a {
            color: #2e6baf;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .card-register a:hover { color: #1a4a80; }
    </style>
</head>
<body>

    <canvas id="bubble-canvas" style="position:fixed;inset:0;pointer-events:none;z-index:0;"></canvas>

    <div class="login-card" style="position:relative;z-index:1;">

        <!-- Title bar -->
        <div class="card-titlebar">
            <span class="card-title-text">QuizMaster — Sign In</span>
            <div class="card-dots">
                <div class="card-dot dot-min"></div>
                <div class="card-dot dot-max"></div>
                <div class="card-dot dot-close"></div>
            </div>
        </div>

        <div class="card-body">

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <div class="card-heading">
                <h1>Welcome Back</h1>
                <p>Sign in to your QuizMaster account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field-group">
                    <label class="field-label" for="email">Email Address</label>
                    <input
                        id="email"
                        class="field-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@example.com"
                    />
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <input
                        id="password"
                        class="field-input"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-row">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <!-- Footer: forgot + submit -->
                <div class="card-footer">
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot your password?</a>
                    @else
                        <span></span>
                    @endif

                    <button type="submit" class="aero-btn">Log in</button>
                </div>
            </form>

            <!-- Register link -->
            @if (Route::has('register'))
                <div class="card-register">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            @endif

        </div>
    </div>

</body>
</html>