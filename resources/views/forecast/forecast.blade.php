<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sales Forecast Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
            color: var(--dark-text);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .dashboard-navbar {
            background: var(--burgundy);
            color: var(--gold);
            padding: 1.2em 0.5em 1.2em 2em;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 12px rgba(94, 15, 15, 0.08);
        }
        .dashboard-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 2px;
            margin-right: 1.5em;
            display: flex;
            align-items: center;
        }
        .dashboard-logo i {
            margin-right: 0.6em;
            color: var(--gold);
        }
        .dashboard-title {
            font-size: 1.2rem;
            color: var(--light-text);
            font-weight: 500;
            letter-spacing: 1px;
        }
        .dashboard-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
            padding: 0 0 3em 0;
        }
        .dashboard-content {
            max-width: 900px;
            margin: 2.5em auto 0 auto;
            padding: 0 1em;
        }
        .dashboard-cards {
            display: flex;
            gap: 2em;
            margin-bottom: 2em;
            flex-wrap: wrap;
        }
        .summary-card {
            flex: 1 1 180px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(200, 169, 126, 0.10);
            padding: 1.2em 1.5em;
            display: flex;
            align-items: center;
            gap: 1em;
            border: 1.5px solid var(--gold);
            min-width: 180px;
        }
        .summary-icon {
            font-size: 2.2rem;
            color: var(--burgundy);
            background: var(--gold);
            border-radius: 50%;
            padding: 0.4em 0.6em;
            box-shadow: 0 2px 8px rgba(200, 169, 126, 0.10);
        }
        .summary-info {
            display: flex;
            flex-direction: column;
        }
        .summary-label {
            font-size: 0.98rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .summary-value {
            font-size: 1.3rem;
            color: var(--dark-text);
            font-weight: 700;
        }
        .forecast-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(94, 15, 15, 0.10);
            padding: 2.5em 2em 2em 2em;
            border: 1.5px solid var(--gold);
        }
        .forecast-header {
            text-align: center;
            margin-bottom: 2em;
        }
        .forecast-header h1 {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 2.2rem;
            margin-bottom: 0.5em;
        }
        .divider {
            width: 60px;
            height: 3px;
            background: var(--gold);
            margin: 0.5em auto 1.5em auto;
            border-radius: 2px;
        }
        #forecast-form {
            display: flex;
            flex-direction: column;
            gap: 1.2em;
            margin-bottom: 2em;
        }
        #forecast-form label {
            font-weight: 600;
            color: var(--burgundy);
            margin-bottom: 0.3em;
        }
        #forecast-form select {
            padding: 0.7em 1em;
            border-radius: 8px;
            border: 1.5px solid var(--gold);
            font-size: 1rem;
            background: var(--cream);
            color: var(--dark-text);
        }
        #forecast-form button {
            background: var(--burgundy);
            color: var(--light-text);
            border: none;
            border-radius: 8px;
            padding: 0.8em 0;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 0.5em;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        #forecast-form button:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 0.7em 1em;
            border-radius: 8px;
            margin-bottom: 1em;
            font-size: 0.98rem;
            text-align: center;
        }
        .chart-card {
            background: linear-gradient(135deg, var(--cream) 60%, #fff 100%);
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(200, 169, 126, 0.10);
            padding: 1.5em 1em 1em 1em;
            margin-top: 1.5em;
        }
        @media (max-width: 1000px) {
            .dashboard-content { max-width: 98vw; }
            .dashboard-cards { flex-direction: column; gap: 1em; }
        }
        @media (max-width: 700px) {
            .forecast-section, .forecast-container { padding: 1.2em 0.5em; }
            .chart-card { padding: 1em 0.2em 0.5em 0.2em; }
            .dashboard-navbar { flex-direction: column; align-items: flex-start; padding: 1em 1em; }
            .dashboard-logo { font-size: 1.3rem; }
        }
    </style>
</head>
<body>
    <div class="dashboard-bg">
        <div class="dashboard-navbar">
            <span class="dashboard-logo"><i class="fa-solid fa-chart-line"></i> Terravin</span>
            <span class="dashboard-title">Forecast Dashboard</span>
        </div>
        <div class="dashboard-content">
            <div class="dashboard-cards">
                <div class="summary-card">
                    <span class="summary-icon"><i class="fa-solid fa-list"></i></span>
                    <div class="summary-info">
                        <span class="summary-label">Total Categories</span>
                        <span class="summary-value">{{ count($categories) }}</span>
                    </div>
                </div>
                <div class="summary-card">
                    <span class="summary-icon"><i class="fa-solid fa-calendar-day"></i></span>
                    <div class="summary-info">
                        <span class="summary-label">Last Prediction</span>
                        <span class="summary-value" id="last-prediction">-</span>
                    </div>
                </div>
            </div>
            <div class="forecast-section">
                <div class="forecast-header">
                    <h1>Sales Forecast</h1>
                    <div class="divider"></div>
                </div>
                <form id="forecast-form">
                    <label for="category">Select Category:</label>
                    <select id="category" name="category" required>
                        <option value="">-- Choose Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Predict Next 5 Months</button>
                </form>
                <div id="error-message" class="error" style="display:none;"></div>
                <div class="chart-card">
                    <canvas id="forecast-chart" width="600" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('forecast-form');
        const chartCanvas = document.getElementById('forecast-chart');
        const errorDiv = document.getElementById('error-message');
        const lastPrediction = document.getElementById('last-prediction');
        let forecastChart = null;
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            const category = document.getElementById('category').value;
            if (!category) {
                errorDiv.textContent = 'Please select a category.';
                errorDiv.style.display = 'block';
                return;
            }
            fetch("{{ route('forecast.predict') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ category })
            })
            .then(res => res.json())
            .then(data => {
                const labels = data.map(item => item.month);
                const values = data.map(item => item.quantity);
                const errors = data.filter(item => item.error).map(item => item.error);
                if (errors.length > 0) {
                    errorDiv.textContent = errors.join(' | ');
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
                if (forecastChart) forecastChart.destroy();
                forecastChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Predicted Quantity',
                            data: values,
                            borderColor: 'var(--burgundy)',
                            backgroundColor: 'rgba(200, 169, 126, 0.15)',
                            pointBackgroundColor: 'var(--gold)',
                            fill: true,
                            tension: 0.25
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
                // Set last prediction summary
                if (labels.length && values.length) {
                    lastPrediction.textContent = labels[labels.length-1] + ': ' + values[values.length-1];
                } else {
                    lastPrediction.textContent = '-';
                }
            })
            .catch(err => {
                errorDiv.textContent = 'An error occurred: ' + err;
                errorDiv.style.display = 'block';
            });
        });
    </script>
</body>
</html>