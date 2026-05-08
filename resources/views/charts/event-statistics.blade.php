<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Statistiken</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .chart-wrapper {
            margin-bottom: 30px;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding: 20px 0;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .info-box {
            background: #f8f9ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .info-box h3 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .info-box p {
            color: #666;
            line-height: 1.6;
        }

        footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Event Statistiken Dashboard</h1>
            <p>GFU Schulung 2026 - Charts und PDF Export</p>
        </div>

        <div class="content">
            <div class="info-box">
                <h3>ℹ️ Über dieses Dashboard</h3>
                <p>
                    Dieses Dashboard zeigt die Statistiken aller Events im System.
                    Die Daten werden automatisch aus der Datenbank aggregiert und in einem interaktiven Chart angezeigt.
                    Sie können das Chart als PDF exportieren.
                </p>
            </div>

            <div class="chart-wrapper">
                {!! $chart->container() !!}
            </div>

            <div class="actions">
                <button class="btn btn-primary" onclick="document.location.href='/charts/event-statistics';">🔄 Aktualisieren</button>
                <a href="{{ route('charts.eventStatisticsPdf') }}" class="btn btn-primary">📥 Als PDF exportieren</a>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">← Zurück zu Events</a>
            </div>
        </div>

        <footer>
            <p>&copy; 2026 GFU Schulung | Laravel Chart Export Beispiel</p>
        </footer>
    </div>

    {!! $chart->script() !!}
</body>
</html>

