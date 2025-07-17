@extends('layouts.admin')
@section('title', 'Sales Forecast Dashboard')

@push('styles')
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
        /* max-width: 900px; */
        width: 100%;
        margin: 2.5em auto 0 auto;
        padding: 0 0.5em;
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
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
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
        padding: 2em 2em 1.5em 2em;
        margin-top: 1.5em;
        width: 100%;
        min-width: 0;
        overflow-x: auto;
    }
    @media (max-width: 1000px) {
        .dashboard-content { width: 100vw; max-width: 100vw; }
        .forecast-section { max-width: 100vw; padding: 1.2em 0.5em; }
        .chart-card { padding: 1em 0.2em 0.5em 0.2em; }
        .dashboard-navbar { flex-direction: column; align-items: flex-start; padding: 1em 1em; }
        .dashboard-logo { font-size: 1.3rem; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-bg">
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
            <div class="forecast-header" style="display: flex; align-items: center; justify-content: center; gap: 1em; flex-wrap: wrap;">
                <h1 style="margin-bottom: 0;">Sales Forecast</h1>
                <a href="{{ route('forecast.download') }}" id="download-csv-btn" class="download-btn" style="background: var(--gold); color: var(--burgundy); border: none; border-radius: 8px; padding: 0.6em 1.2em; font-size: 1.05rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.5em; box-shadow: 0 2px 8px rgba(200,169,126,0.10); transition: background 0.2s, color 0.2s;">
                    <i class="fa-solid fa-download"></i> Download CSV
                </a>
                <div class="divider" style="flex-basis: 100%;"></div>
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
                <div style="display: flex; justify-content: center; margin-top: 1em;">
                    <a href="#" id="download-forecast-chart" class="download-btn" style="background: var(--gold); color: var(--burgundy); border: none; border-radius: 8px; padding: 0.6em 1.2em; font-size: 1.05rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 0.5em; box-shadow: 0 2px 8px rgba(200,169,126,0.10); transition: background 0.2s, color 0.2s;">
                        <i class="fa-solid fa-image"></i> Download Chart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const form = document.getElementById('forecast-form');
    const chartCanvas = document.getElementById('forecast-chart');
    const errorDiv = document.getElementById('error-message');
    const lastPrediction = document.getElementById('last-prediction');
    const downloadCsvBtn = document.getElementById('download-csv-btn');
    let forecastChart = null;
    let predictionMade = false;

    // Disable CSV button initially
    downloadCsvBtn.addEventListener('click', function(e) {
        if (!predictionMade) {
            e.preventDefault();
            errorDiv.textContent = 'First generate a prediction';
            errorDiv.style.display = 'block';
        }
    });
    // Optionally, visually indicate disabled state
    downloadCsvBtn.style.pointerEvents = 'auto';
    downloadCsvBtn.style.opacity = '0.5';

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
                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
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
                predictionMade = false;
                downloadCsvBtn.style.opacity = '0.5';
            } else {
                errorDiv.style.display = 'none';
                predictionMade = true;
                downloadCsvBtn.style.opacity = '1';
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
            predictionMade = false;
            downloadCsvBtn.style.opacity = '0.5';
        });
    });
    document.getElementById('download-forecast-chart').addEventListener('click', function(e) {
        e.preventDefault();
        if (forecastChart) {
            // Save original options
            const origBg = forecastChart.options.plugins.legend.labels.color;
            const origGrid = forecastChart.options.scales.y.grid.color;
            const origTicks = forecastChart.options.scales.y.ticks.color;
            // Set light theme for export
            forecastChart.options.plugins.legend.labels.color = '#222';
            forecastChart.options.scales.y.grid.color = '#eee';
            forecastChart.options.scales.y.ticks.color = '#222';
            forecastChart.options.scales.x.grid.color = '#eee';
            forecastChart.options.scales.x.ticks.color = '#222';
            forecastChart.options.plugins.title = { display: false };
            forecastChart.options.backgroundColor = '#fff';
            forecastChart.update();
            // Create a white background for the canvas
            const canvas = forecastChart.canvas;
            const ctx = canvas.getContext('2d');
            const w = canvas.width, h = canvas.height;
            const temp = ctx.getImageData(0, 0, w, h);
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, w, h);
            ctx.restore();
            // Download
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'forecast_chart.png';
            link.click();
            // Restore chart
            ctx.putImageData(temp, 0, 0);
            forecastChart.options.plugins.legend.labels.color = origBg;
            forecastChart.options.scales.y.grid.color = origGrid;
            forecastChart.options.scales.y.ticks.color = origTicks;
            forecastChart.options.scales.x.grid.color = origGrid;
            forecastChart.options.scales.x.ticks.color = origTicks;
            forecastChart.options.backgroundColor = undefined;
            forecastChart.update();
        } else {
            alert('Please generate a forecast chart first.');
        }
    });
</script>
@endpush