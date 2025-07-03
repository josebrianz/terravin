<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terravin Wine - Login">
    <title>Login | TERRAVIN WINE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400&family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --dark-text: #2a2a2a;
            --light-text: #f8f8f8;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--cream);
            color: var(--dark-text);
            margin: 0;
            min-height: 100vh;
        }
        .hero {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('https://images.unsplash.com/photo-1474722883778-792e7990302f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--light-text);
            padding: 0 2rem;
        }
        .logo {
            font-family:'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .login-card {
            background: rgba(245, 240, 230, 0.97);
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(94, 15, 15, 0.25), 0 2px 8px 0 rgba(200, 169, 126, 0.10);
            border: 2.5px solid var(--burgundy);
            padding: 3.5rem 2.7rem 2.7rem 2.7rem;
            max-width: 520px;
            width: 100%;
            margin: 2rem auto 0 auto;
            color: var(--dark-text);
            position: relative;
            overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(94, 15, 15, 0.08) 0%, rgba(200, 169, 126, 0.04) 100%);
            z-index: 0;
            border-radius: 16px;
        }
        .login-card > * {
            position: relative;
            z-index: 1;
        }
        .login-card h2 {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }
        .form-group {
            margin-bottom: 1.2rem;
            text-align: left;
        }
        label {
            font-weight: 500;
            color: var(--burgundy);
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid var(--gold);
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255,255,255,0.7);
            margin-bottom: 0.3rem;
        }
        input[type="checkbox"] {
            accent-color: var(--burgundy);
        }
        .remember-label {
            color: var(--burgundy);
            font-size: 0.98rem;
        }
        .login-btn {
            width: 100%;
            background: transparent;
            color: var(--burgundy);
            border: 2px solid var(--gold);
            padding: 0.8rem 0;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 1.2rem;
            transition: all 0.3s ease;
            border-radius: 12px;
            cursor: pointer;
        }
        .login-btn:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        .forgot-link {
            color: var(--gold);
            text-decoration: none;
            font-size: 0.98rem;
            float: right;
            margin-top: 0.2rem;
        }
        .forgot-link:hover {
            color: var(--burgundy);
        }
        .session-status, .input-error {
            color: var(--burgundy);
            background: #fff8f3;
            border-left: 3px solid var(--gold);
            padding: 0.7rem 1rem;
            border-radius: 0 8px 8px 0;
            margin-bottom: 1rem;
            font-size: 0.98rem;
        }
        @media (max-width: 500px) {
            .login-card {
                padding: 2rem 0.7rem;
            }
            .logo {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="hero">
        <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 1rem;">
        <span class="logo">Terravin Winery</span>
        </div>
        <div class="login-card">
            <h2>Sign In</h2>
            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" style="display: flex; align-items: center; justify-content: space-between;">
                    <label class="remember-label"><input id="remember_me" type="checkbox" name="remember"> Remember me</label>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                </div>
                <button type="submit" class="login-btn">Log in</button>
            </form>
        </div>
    </div>
</body>
</html>
