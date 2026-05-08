<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Statistics Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: white;
            padding: 30px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        #chart {
            width: 100%;
            min-height: 500px;
            background: white;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Event Statistiken 2026</h1>
            <p>Events pro Monat</p>
        </div>

        <div id="chart"></div>

        <div class="footer">
            <p>© 2026 GFU Schulung - Automatisch generiert am {{ now()->format('d.m.Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const options = {
                chart: {
                    type: 'bar',
                    height: 500,
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: false
                    }
                },
                series: [{
                    name: 'Events',
                    data: {!! json_encode($values) !!}
                }],
                xaxis: {
                    categories: {!! json_encode($months) !!}
                },
                colors: {!! json_encode($colors) !!},
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        fontWeight: 600
                    }
                },
                grid: {
                    borderColor: '#e0e0e0'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector('#chart'), options);
            chart.render();
        });
    </script>
</body>
</html>


