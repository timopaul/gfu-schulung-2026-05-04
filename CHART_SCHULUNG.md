# Chart und PDF Export - Schulungsbeispiel

Dieses Beispiel zeigt die Erstellung von Charts mit **LarapexCharts** und deren Export als PDF mit **dompdf**.

## 🚀 Installation

### 1. Abhängigkeiten installieren

```bash
composer require barryvdh/laravel-dompdf
composer require arielmejiaDev/larapex-charts
```

### 2. Routes testen

Nach der Installation können die folgenden Routes verwendet werden:

```
GET /charts/event-statistics          → Chart als HTML anzeigen
GET /charts/event-statistics/pdf      → Chart als PDF exportieren
```

## 📁 Projektstruktur

```
app/
├── Charts/
│   └── EventStatisticsChart.php       ← Chart-Logik
└── Http/
    └── Controllers/
        └── ChartController.php        ← Controller für Routes

resources/
└── views/
    └── charts/
        ├── event-statistics.blade.php     ← HTML-Darstellung
        └── event-statistics-pdf.blade.php ← PDF-Template
```

## 📊 Wie funktioniert's?

### 1. Chart-Klasse (`EventStatisticsChart.php`)

Die Chart-Klasse ist **separiert von der Logik** und kann wiederverwendet werden:

```php
class EventStatisticsChart
{
    public function build(): LarapexChart
    {
        // Daten aus DB aggregieren
        $eventsByMonth = Event::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('count', 'month');

        // Chart konfigurieren
        return $this->chart
            ->barChart()
            ->setTitle('Event Statistiken 2026')
            ->addData('Events', $data)
            ->setXAxis($months);
    }
}
```

**Vorteil:** Sie können diese Klasse in mehreren Controllern/Views verwenden!

### 2. Controller (`ChartController.php`)

Der Controller hat zwei Methoden:

```php
// Route: /charts/event-statistics
public function eventStatistics(): View
{
    $chart = new EventStatisticsChart();
    return view('charts.event-statistics', ['chart' => $chart->build()]);
}

// Route: /charts/event-statistics/pdf
public function eventStatisticsPdf(): Response
{
    $chart = new EventStatisticsChart();
    $pdf = Pdf::loadView('charts.event-statistics-pdf', ['chart' => $chart->build()]);
    return $pdf->download('event-statistics.pdf');
}
```

### 3. Views

**HTML-View** (`event-statistics.blade.php`):
```blade
{!! $chart->container() !!}    {! Chart Container !}
{!! $chart->script() !!}       {! JavaScript für interaktives Chart !}
```

**PDF-View** (`event-statistics-pdf.blade.php`):
```blade
{! Gleiches Chart mit PDF-optimiertem Layout !}
```

## 💡 Verwendbare Chart-Typen

LarapexCharts unterstützt viele Chart-Typen:

```php
$chart->barChart()          // Balkendiagramm
$chart->lineChart()         // Liniendiagramm
$chart->areaChart()         // Flächendiagramm
$chart->pieChart()          // Kreisdiagramm
$chart->donutChart()        // Donutdiagramm
$chart->radarChart()        // Radardiagramm
$chart->scatterChart()      // Streudiagramm
```

## 📝 Beispiel: Neues Chart erstellen

### 1. Neue Chart-Klasse

```php
// app/Charts/UserStatisticsChart.php
namespace App\Charts;

class UserStatisticsChart
{
    public function build(): LarapexChart
    {
        $users = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupByRaw('DATE(created_at)')
            ->get();

        return (new LarapexChart())
            ->lineChart()
            ->setTitle('Neue Benutzer')
            ->addData('Benutzer', $users->pluck('count'))
            ->setXAxis($users->pluck('date'));
    }
}
```

### 2. Controller-Methode

```php
public function userStatistics()
{
    $chart = new UserStatisticsChart();
    return view('charts.users', ['chart' => $chart->build()]);
}
```

### 3. Route

```php
Route::get('/charts/users', [ChartController::class, 'userStatistics']);
```

## 🔗 Hilfreiches

- **LarapexCharts Docs:** https://github.com/ArielMejiaDev/larapex-charts
- **DomPDF Docs:** https://github.com/barryvdh/laravel-dompdf
- **ApexCharts.js:** https://apexcharts.com/

## 🎓 Aufgaben für Trainees

1. **Einfach:** Erstellen Sie ein neues Chart für Event-Typen (gruppiert nach EventType)
2. **Mittel:** Erweitern Sie das Chart mit mehreren Datenreihen (z.B. Events + Nutzer)
3. **Fortgeschritten:** Implementieren Sie einen Datums-Filter für das Chart

## ✅ Checkliste

- [ ] Packages installiert (`composer require ...`)
- [ ] Chart-Klasse erstellt und getestet
- [ ] Controller erstellt
- [ ] Routes in `routes/web.php` hinzugefügt
- [ ] Views erstellt
- [ ] HTML-Darstellung getestet: `/charts/event-statistics`
- [ ] PDF-Export getestet: `/charts/event-statistics/pdf`

---

**Viel Erfolg bei der Schulung!** 🎉

