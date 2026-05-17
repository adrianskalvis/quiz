<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'QuizMaster') }} — Log in</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/pages/auth.css', 'resources/js/app.js'])
    
</head>
<body>

    <canvas id="bubble-canvas" class="auth-bubble-canvas"></canvas>

    <div class="login-card auth-card">

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
