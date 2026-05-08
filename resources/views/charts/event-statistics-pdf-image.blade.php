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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #667eea;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .content {
            padding: 10px 0;
        }

        .info-section {
            background: #f8f9ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 2px;
            page-break-inside: avoid;
        }

        .info-section h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .info-section p {
            font-size: 12px;
            line-height: 1.4;
        }

        .chart-container {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            page-break-inside: avoid;
            text-align: center;
        }

        .chart-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .chart-image {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12px;
            page-break-inside: avoid;
        }

        .data-table th {
            background-color: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8f9ff;
        }

        .total-row {
            background-color: #667eea !important;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #999;
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
                <strong>Zeitraum:</strong> Januar - Dezember 2026<br/>
                <strong>Generiert am:</strong> {{ now()->format('d.m.Y H:i:s') }}<br/>
                <strong>Bericht-Typ:</strong> Event Statistiken Übersicht
            </p>
        </div>

        <div class="chart-container">
            <div class="chart-title">Events pro Monat 2026</div>
            <img src="{{ $chartImage }}" alt="Event Statistics Chart" class="chart-image" />
        </div>

        <div class="info-section">
            <h3>📊 Datentabelle</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Monat</th>
                        <th style="text-align: right;">Anzahl Events</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chartData['months'] as $index => $month)
                        <tr>
                            <td>{{ $month }}</td>
                            <td style="text-align: right;"><strong>{{ $chartData['data'][$index] }}</strong></td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Gesamt</td>
                        <td style="text-align: right;">{{ array_sum($chartData['data']) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-section">
            <h3>📝 Erklärung</h3>
            <p>
                Das obenstehende Balkendiagramm zeigt die Anzahl der Events pro Monat für das Jahr 2026.
                Das Chart wird direkt aus der Web-Anwendung mit ApexCharts gerendert und als Screenshot in diesem PDF eingebettet.
            </p>
        </div>
    </div>

    <div class="footer">
        <p>© 2026 GFU Schulung - Alle Rechte vorbehalten</p>
        <p>Generiert: {{ now()->format('d. F Y um H:i') }}</p>
    </div>
</body>
</html>

