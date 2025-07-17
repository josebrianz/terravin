<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status | Terravin</title>
    <style>
        body {
            background: #f5f0e6;
            color: #5e0f0f;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .status-container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(94, 15, 15, 0.08);
            padding: 2.5rem 2rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .wine-icon {
            font-size: 2.5rem;
            color: #c8a97e;
            margin-bottom: 1rem;
        }
        .status-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #5e0f0f;
        }
        .status-message {
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
        }
        .timer {
            font-size: 1.2rem;
            font-weight: 600;
            color: #8b1a1a;
            margin-bottom: 0.5rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="status-container">
        <div class="wine-icon"><i class="fas fa-wine-bottle"></i></div>
        <div class="status-title">Application Status</div>
        <div class="status-message">
            Your application for a new role is pending admin approval.<br>
            Please wait while we process your request.
        </div>
        <div class="timer" id="timer">02:00</div>
        <div style="font-size:0.95rem;color:#b8945f;">This page will update automatically after 2 minutes.</div>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:1.5rem;">
            @csrf
            <button type="submit" style="background:#5e0f0f;color:#fff;border:none;padding:0.7rem 2.2rem;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;transition:background 0.2s;">Logout</button>
        </form>
    </div>
    <script>
        let time = 120;
        const timerEl = document.getElementById('timer');
        const interval = setInterval(() => {
            time--;
            const min = String(Math.floor(time / 60)).padStart(2, '0');
            const sec = String(time % 60).padStart(2, '0');
            timerEl.textContent = `${min}:${sec}`;
            if (time <= 0) {
                clearInterval(interval);
                timerEl.textContent = '00:00';
                // Optionally, reload or redirect after timer ends
                location.reload();
            }
        }, 1000);
    </script>
</body>
</html> 