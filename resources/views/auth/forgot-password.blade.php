<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'QuizMaster') }} — Reset Password</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/pages/auth.css', 'resources/js/app.js'])
</head>
<body>

    <canvas id="bubble-canvas" class="auth-bubble-canvas"></canvas>

    <div class="login-card auth-card">

        <div class="card-titlebar">
            <span class="card-title-text">QuizMaster — Reset Password</span>
            <div class="card-dots">
                <div class="card-dot dot-min"></div>
                <div class="card-dot dot-max"></div>
                <div class="card-dot dot-close"></div>
            </div>
        </div>

        <div class="card-body">

            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <div class="card-heading">
                <h1>Reset Password</h1>
                <p>Enter your email and QuizMaster will send you a reset link.</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

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

                <div class="card-footer">
                    <a class="forgot-link" href="{{ route('login') }}">Back to log in</a>
                    <button type="submit" class="aero-btn">Send reset link</button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="card-register">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
