<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Event Statistiken PDF</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            padding: 30px 0;
            border-bottom: 3px solid #667eea;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .content {
            padding: 20px 0;
        }

        .chart-container {
            margin: 30px 0;
        }

        .info-section {
            background: #f8f9ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-section h3 {
            color: #667eea;
            margin-bottom: 8px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #999;
        }

        .timestamp {
            text-align: right;
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Event Statistiken Report</h1>
        <p>GFU Schulung 2026 - Automatisch generiert</p>
    </div>

    <div class="content">
        <div class="info-section">
            <h3>Bericht-Informationen</h3>
            <p>
                <strong>Zeitraum:</strong> Januar - Dezember 2026<br>
                <strong>Generiert am:</strong> {{ now()->format('d.m.Y H:i:s') }}<br>
                <strong>Bericht-Typ:</strong> Event Statistiken Übersicht
            </p>
        </div>

        <div class="chart-container">
            {!! $chart->container() !!}
        </div>

        <div class="info-section">
            <h3>📝 Erklärung</h3>
            <p>
                Das obenstehende Balkendiagramm zeigt die Anzahl der Events pro Monat für das Jahr 2026.
                Die Daten werden automatisch aus der Datenbank aggregiert und aktualisiert.
            </p>
        </div>
    </div>

    <div class="footer">
        <p>© 2026 GFU Schulung - Alle Rechte vorbehalten</p>
        <div class="timestamp">
            Generiert: {{ now()->format('d. F Y \u{u0075}m H:i') }}
        </div>
    </div>

    {!! $chart->script() !!}
</body>
</html>

