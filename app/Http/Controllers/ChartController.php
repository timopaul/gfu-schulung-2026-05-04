<?php

namespace App\Http\Controllers;

use App\Charts\EventStatisticsChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\View as ViewFacade;

class ChartController extends Controller
{
    public function eventStatistics(): View
    {
        $chart = new EventStatisticsChart();

        return view('charts.event-statistics', [
            'chart' => $chart->build()
        ]);
    }

    public function eventStatisticsHtml(): View
    {
        $chart = new EventStatisticsChart();
        $chartData = $chart->getChartData();

        return view('charts.chart-for-screenshot', $chartData);
    }

    public function eventStatisticsPdf(): Response
    {
        $chart = new EventStatisticsChart();
        $chartData = $chart->getChartData();

        // Generiere Screenshot des Charts mit Puppeteer
        $chartImage = $this->captureChartWithPuppeteer($chartData);

        $pdf = Pdf::loadView('charts.event-statistics-pdf-image', [
            'chartData' => $chartData,
            'chartImage' => $chartImage,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('event-statistics.pdf');
    }

    private function captureChartWithPuppeteer(array $chartData): string
    {
        // Erstelle temporäre HTML-Datei
        $tempDir = storage_path('temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $htmlFile = $tempDir . '/chart-' . uniqid() . '.html';
        $pngFile = $tempDir . '/chart-' . uniqid() . '.png';

        // Generiere HTML mit dem Chart
        $html = ViewFacade::make('charts.chart-for-screenshot', $chartData)->render();
        file_put_contents($htmlFile, $html);

        // Puppeteer Script
        $scriptContent = <<<'SCRIPT'
const puppeteer = require('puppeteer');
const path = require('path');

(async () => {
    const htmlFile = process.argv[2];
    const pngFile = process.argv[3];

    let browser;
    try {
        browser = await puppeteer.launch({
            headless: 'new',
            executablePath: '/usr/bin/google-chrome',
            args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage']
        });

        const page = await browser.newPage();
        await page.setViewport({ width: 1400, height: 700 });

        const htmlUrl = 'file://' + path.resolve(htmlFile);
        await page.goto(htmlUrl, { waitUntil: 'networkidle0', timeout: 30000 });

        // Warte bis ApexCharts fertig gerendert ist
        await page.waitForSelector('.apexcharts-canvas', { timeout: 10000 });
        await new Promise(r => setTimeout(r, 1500));

        // Screenshot vom Chart-Container
        const chartElement = await page.$('#chart');
        if (chartElement) {
            await chartElement.screenshot({ path: pngFile, omitBackground: false });
        } else {
            await page.screenshot({ path: pngFile, fullPage: false });
        }

        console.log('Screenshot saved: ' + pngFile);
        process.exit(0);
    } catch (error) {
        console.error('Error:', error.message);
        process.exit(1);
    } finally {
        if (browser) await browser.close();
    }
})();
SCRIPT;

        $scriptFile = $tempDir . '/capture.cjs';
        file_put_contents($scriptFile, $scriptContent);

        // Führe Puppeteer aus
        $process = new Process([
            'node',
            $scriptFile,
            $htmlFile,
            $pngFile
        ]);

        $process->setTimeout(60);
        $process->run();

        if (!$process->isSuccessful()) {
            \Log::error('Puppeteer error: ' . $process->getErrorOutput());
            throw new \Exception('Failed to capture chart: ' . $process->getErrorOutput());
        }

        if (!file_exists($pngFile)) {
            throw new \Exception('Screenshot file not created');
        }

        // Konvertiere zu Base64
        $imageData = file_get_contents($pngFile);
        $base64 = base64_encode($imageData);

        // Cleanup
        @unlink($htmlFile);
        @unlink($pngFile);
        @unlink($scriptFile);

        return 'data:image/png;base64,' . $base64;
    }
}

