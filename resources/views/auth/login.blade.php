<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terravin Wine - Login">
    <title>Login | TERRAVIN WINE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;500;600&family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --dark-text: #2a2a2a;
            --light-text: #f8f8f8;
            --white: #ffffff;
            --shadow: rgba(94, 15, 15, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #f5f0e6 0%, #e8d5b7 100%);
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 60px var(--shadow);
            overflow: hidden;
            min-height: 600px;
        }
        
        .welcome-section {
            flex: 1;
            background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);
            color: var(--light-text);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1474722883778-792e7990302f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            opacity: 0.1;
            z-index: 0;
        }
        
        .welcome-content {
            position: relative;
            z-index: 1;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 20px;
            margin-top: -120px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        
        .welcome-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: var(--gold);
        }
        
        .welcome-message {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .wine-features {
            list-style: none;
            margin-top: 30px;
        }
        
        .wine-features li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }
        
        .wine-features li::before {
            content: '🍷';
            margin-right: 12px;
            font-size: 1.2rem;
        }
        
        .login-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--white);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 50px;
            margin-top: -120px;
        }
        
        .login-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-subtitle {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--burgundy);
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            background: #f8f9fa;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }
        
        .password-field {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gold);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .password-toggle:hover {
            background: rgba(200, 169, 126, 0.1);
            color: var(--burgundy);
        }
        
        .password-toggle:focus {
            outline: none;
            background: rgba(200, 169, 126, 0.2);
            color: var(--burgundy);
        }
        
        .password-toggle.show-password {
            color: var(--burgundy);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(200, 169, 126, 0.1);
        }
        
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--burgundy);
        }
        
        .checkbox-label {
            color: #666;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .forgot-link {
            color: var(--burgundy);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: var(--gold);
        }
        
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);
            color: var(--white);
            border: none;
            padding: 16px 0;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(94, 15, 15, 0.3);
        }
        
        .session-status, .input-error {
            color: #d63384;
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .session-status {
            color: #0f5132;
            background: #d1e7dd;
            border-color: #badbcc;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 500px;
            }
            
            .welcome-section {
                padding: 40px 30px;
                text-align: center;
            }
            
            .login-section {
                padding: 40px 30px;
            }
            
            .logo {
                font-size: 2rem;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .welcome-section, .login-section {
                padding: 30px 20px;
            }
            
            .logo {
                font-size: 1.8rem;
            }
            
            .welcome-title {
                font-size: 1.5rem;
            }
        }
    </style>
    
    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleButton = passwordField.nextElementSibling;
            const icon = toggleButton.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                toggleButton.classList.add('show-password');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                toggleButton.classList.remove('show-password');
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <div class="welcome-content">
                <div class="logo">Terravin Winery</div>
                <h1 class="welcome-title">Welcome Back</h1>
                <p class="welcome-message">
                    Experience the finest wines from our carefully curated collection. 
                    Access your personalized dashboard to manage orders, track shipments, 
                    and explore our premium selection.
                </p>
                <ul class="wine-features">
                    <li>Premium Wine Collection</li>
                    <li>Real-time Order Tracking</li>
                    <li>Expert Wine Recommendations</li>
                    <li>Secure Payment Processing</li>
                </ul>
            </div>
        </div>
        
        <div class="login-section">
            <div class="login-header">
                <h2 class="login-title">Sign In</h2>
                <p class="login-subtitle">Enter your credentials to access your account</p>
            </div>
            
            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-input" required autofocus autocomplete="username" 
                           placeholder="Enter your email">
                    @error('email')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-field">
                        <input id="password" type="password" name="password" 
                               class="form-input" required autocomplete="current-password"
                               placeholder="Enter your password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <label class="checkbox-group">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span class="checkbox-label">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
                
                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
