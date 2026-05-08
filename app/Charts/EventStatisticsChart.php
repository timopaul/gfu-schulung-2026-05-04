<?php

namespace App\Charts;

use App\Models\Event;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class EventStatisticsChart
{
    protected LarapexChart $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart();
    }

    public function build(): LarapexChart
    {
        $eventsByMonth = Event::selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(start_date)')
            ->pluck('count', 'month');

        $months = ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'];
        $data = array_fill(0, 12, 0);

        foreach ($eventsByMonth as $month => $count) {
            $data[$month - 1] = $count;
        }

        return $this->chart
            ->barChart()
            ->setTitle('Event Statistiken 2026')
            ->setSubtitle('Events pro Monat')
            ->addData('Events', array_values($data))
            ->setXAxis($months)
            ->setHeight(400);
    }
}

