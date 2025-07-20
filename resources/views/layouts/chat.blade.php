<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Chat') - Terravin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        :root {
            --chat-navbar-height: 64px;
        }
        body { background: #f5f0e6; }
        .chat-navbar {
            background: #5e0f0f;
            color: #c8a97e;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(94,15,15,0.08);
            height: var(--chat-navbar-height);
        }
        .chat-navbar .brand {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }
        .chat-navbar .brand i {
            margin-right: 0.5rem;
        }
        .chat-navbar .logout {
            color: #c8a97e;
            border: 1px solid #c8a97e;
            border-radius: 2rem;
            padding: 0.3rem 1.2rem;
            background: transparent;
            text-decoration: none;
            font-size: 1rem;
            transition: background 0.2s, color 0.2s;
        }
        .chat-navbar .logout:hover {
            background: #c8a97e;
            color: #5e0f0f;
        }
        .chat-content-wrapper {
            margin-top: var(--chat-navbar-height);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="chat-navbar">
        <div class="brand">
            <i class="fas fa-comments"></i> Terravin Chat
        </div>
        <a href="/logout" class="logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
    <div class="chat-content-wrapper">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html> 