<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terravin Wine - Register">
    <title>Register | TERRAVIN WINE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --light-burgundy: #8b1a1a;
            --gold: #c8a97e;
            --dark-gold: #b8945f;
            --cream: #f5f0e6;
            --light-cream: #f9f5ed;
            --dark-text: #2a2a2a;
            --light-text: #f8f8f8;
            --white: #ffffff;
            --gray: #e1e5e9;
            --shadow: 0 10px 30px rgba(94, 15, 15, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-cream);
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            line-height: 1.6;
        }
        
        .container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            min-height: 700px;
            position: relative;
        }
        
        /* Hero Section */
        .hero-section {
            flex: 1;
            background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
            color: var(--light-text);
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            opacity: 0.08;
            z-index: -1;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
            margin-top: -250px;
            white-space: nowrap;
            line-height: 1;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--gold);
            line-height: 1.3;
        }
        
        .hero-text {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2.5rem;
            max-width: 90%;
        }
        
        .features-list {
            list-style: none;
            margin-top: 2rem;
        }
        
        .features-list li {
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            font-size: 1rem;
            position: relative;
            padding-left: 2rem;
        }
        
        .features-list li::before {
            content: '';
            position: absolute;
            left: 0;
            width: 24px;
            height: 24px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--burgundy);
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 0.8rem;
        }
        
        .features-list li:nth-child(1)::before { content: '\f06c'; } /* wine bottle */
        .features-list li:nth-child(2)::before { content: '\f075'; } /* comments */
        .features-list li:nth-child(3)::before { content: '\f0d1'; } /* tracking */
        .features-list li:nth-child(4)::before { content: '\f005'; } /* star */
        
        /* Form Section */
        .form-section {
            flex: 1;
            padding: 1.5rem 4rem 4rem 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--white);
        }
        
        .form-container {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            padding-top: 0;
        }
        
        .form-header {
            margin-bottom: 3rem;
            text-align: center;
        }
        
        .form-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: var(--burgundy);
            font-size: 0.95rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid var(--gray);
            border-radius: 10px;
            font-size: 1rem;
            background: var(--light-cream);
            transition: var(--transition);
            font-family: 'Montserrat', sans-serif;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(200, 169, 126, 0.2);
            background: var(--white);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 1.1rem;
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
            transition: var(--transition);
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
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }
        
        .login-link {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            font-size: 0.95rem;
        }
        
        .login-link:hover {
            color: var(--burgundy);
            text-decoration: underline;
        }
        
        .submit-btn {
            width: 100%;
            background: var(--burgundy);
            color: var(--white);
            border: none;
            padding: 1.1rem;
            font-size: 1.05rem;
            font-weight: 600;
            margin-top: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(94, 15, 15, 0.1);
            letter-spacing: 0.5px;
        }
        
        .submit-btn:hover {
            background: var(--light-burgundy);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(94, 15, 15, 0.15);
        }
        
        .error-message {
            color: #d32f2f;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
                min-height: auto;
            }
            
            .hero-section, .form-section {
                padding: 3rem 2rem;
            }
            
            .hero-section {
                text-align: center;
            }
            
            .logo {
                font-size: 2.2rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .form-title {
                font-size: 2rem;
        }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }
            
            .container {
                border-radius: 12px;
            }
            
            .hero-section, .form-section {
                padding: 2.5rem 1.5rem;
            }
            
            .logo {
                font-size: 2.2rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .form-title {
                font-size: 2rem;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="logo">Terravin Winery</div>
            <h1 class="hero-title">Discover the Art of Fine Wine</h1>
            <p class="hero-text">Join our exclusive community of wine enthusiasts and gain access to curated collections, expert recommendations, and special members-only events.</p>
            
            <ul class="features-list">
                <li>Premium selection of rare and vintage wines</li>
                <li>Personalized recommendations from our sommeliers</li>
                <li>Exclusive members-only events and tastings</li>
                <li>Direct access to boutique wineries</li>
            </ul>
        </div>
        
        <!-- Form Section -->
        <div class="form-section">
            <div class="form-container">
                <div class="form-header">
                    <h1 class="form-title">Create Account</h1>
                    <p class="form-subtitle">Begin your wine journey with us</p>
                </div>
                
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
        @csrf
                    
                <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-input" placeholder="John Smith">
                        </div>
                    @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                    @enderror
                </div>
                    
                <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="your@email.com">
                        </div>
                    @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                    @enderror
                </div>
                    
                <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password" name="password" required class="form-input" placeholder="••••••••" autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                    @enderror
        </div>
                    
                <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input" placeholder="••••••••" autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
        </div>
                    
                <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-tag input-icon"></i>
                            <select id="role" name="role" required class="form-input" style="padding-left: 3rem;">
                                <option value="">Select your role</option>
                                <option value="Vendor" {{ old('role') == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                                <option value="Wholesaler" {{ old('role') == 'Wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                                <option value="Retailer" {{ old('role') == 'Retailer' ? 'selected' : '' }}>Retailer</option>
                            </select>
                        </div>
                    @error('role')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                    @enderror
        </div>
                    
                    <button type="submit" class="submit-btn">Create Account</button>
                    
                    <div class="form-footer">
                        <a class="login-link" href="{{ route('login') }}">
                            Already have an account? Sign in
                        </a>
        </div>
            </form>
            </div>
        </div>
        </div>
        
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
</body>
</html>