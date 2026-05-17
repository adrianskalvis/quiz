<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'QuizMaster') }} — Register</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/pages/auth.css', 'resources/js/app.js'])
</head>
<body>

    <canvas id="bubble-canvas" class="auth-bubble-canvas"></canvas>

    <div class="login-card auth-card">

        <!-- Title bar -->
        <div class="card-titlebar">
            <span class="card-title-text">QuizMaster — Create Account</span>
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
                <h1>Create Account</h1>
                <p>Join QuizMaster and start playing</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="field-group">
                    <label class="field-label" for="name">Name</label>
                    <input
                        id="name"
                        class="field-input"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Your name"
                    />
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

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
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="field-group">
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        class="field-input"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    @error('password_confirmation')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Footer: login link + submit -->
                <div class="card-footer">
                    <a class="forgot-link" href="{{ route('login') }}">Already registered?</a>
                    <button type="submit" class="aero-btn">Register</button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
