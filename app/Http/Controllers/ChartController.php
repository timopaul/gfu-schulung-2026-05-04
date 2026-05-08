<?php

namespace App\Http\Controllers;

use App\Charts\EventStatisticsChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ChartController extends Controller
{
    public function eventStatistics(): View
    {
        $chart = new EventStatisticsChart();

        return view('charts.event-statistics', [
            'chart' => $chart->build()
        ]);
    }

    public function eventStatisticsPdf(): Response
    {
        $chart = new EventStatisticsChart();

        $pdf = Pdf::loadView('charts.event-statistics-pdf', [
            'chart' => $chart->build()
        ]);

        return $pdf->download('event-statistics.pdf');
    }
}

