<!DOCTYPE html>
<html>
<head>
    <title>Sales Forecast Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #forecast-chart { max-width: 600px; margin: 2em auto; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Sales Forecast Dashboard</h1>
    <form id="forecast-form" style="margin-bottom: 2em;">
        <label for="category">Select Category:</label>
        <select id="category" name="category" required>
            <option value="">-- Choose Category --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
        <button type="submit">Predict Next 5 Months</button>
    </form>
    <div id="error-message" class="error"></div>
    <canvas id="forecast-chart" width="600" height="300"></canvas>
    <script>
        const form = document.getElementById('forecast-form');
        const chartCanvas = document.getElementById('forecast-chart');
        const errorDiv = document.getElementById('error-message');
        let forecastChart = null;
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            errorDiv.textContent = '';
            const category = document.getElementById('category').value;
            if (!category) {
                errorDiv.textContent = 'Please select a category.';
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
                }
                if (forecastChart) forecastChart.destroy();
                forecastChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Predicted Quantity',
                            data: values,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            fill: true,
                            tension: 0.2
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
            })
            .catch(err => {
                errorDiv.textContent = 'An error occurred: ' + err;
            });
        });
    </script>
</body>
</html>