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
        $data = $this->extractData();

        return $this->chart
            ->barChart()
            ->setTitle('Event Statistiken 2026')
            ->setSubtitle('Events pro Monat')
            ->addData('Events', $data['values'])
            ->setXAxis($data['months'])
            ->setColors($data['colors'])
            ->setHeight(400);
    }

    public function getChartData(): array
    {
        return $this->extractData();
    }

    protected function extractData(): array
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

        $colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A', '#98D8C8',
            '#F7DC6F', '#BB8FCE', '#85C1E2', '#F8B88B', '#A9DFBF',
            '#F1948A', '#D7BDE2'
        ];

        return [
            'months' => $months,
            'values' => array_values($data),
            'data' => $data,
            'colors' => $colors,
        ];
    }
}

