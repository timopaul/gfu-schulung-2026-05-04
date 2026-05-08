<?php

require '/home/timo/PhpstormProjects/gfu-schulung-2026-05-04/vendor/autoload.php';

$app = require '/home/timo/PhpstormProjects/gfu-schulung-2026-05-04/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Charts\EventStatisticsChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\View as ViewFacade;

try {
    $chart = new EventStatisticsChart();
    $chartData = $chart->getChartData();

    $tempDir = storage_path('temp');
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0755, true);
    }

    $htmlFile = $tempDir . '/chart-' . uniqid() . '.html';
    $pngFile  = $tempDir . '/chart-' . uniqid() . '.png';
    $scriptFile = $tempDir . '/capture.cjs';

    $html = ViewFacade::make('charts.chart-for-screenshot', $chartData)->render();
    file_put_contents($htmlFile, $html);
    echo "HTML file created: $htmlFile\n";

    $scriptContent = <<<'SCRIPT'
const puppeteer = require('puppeteer');
const path = require('path');

(async () => {
    const htmlFile = process.argv[2];
    const pngFile  = process.argv[3];
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
        console.log('Loading: ' + htmlUrl);
        await page.goto(htmlUrl, { waitUntil: 'networkidle0', timeout: 30000 });
        await page.waitForSelector('.apexcharts-canvas', { timeout: 10000 });
        await new Promise(r => setTimeout(r, 1500));
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

    file_put_contents($scriptFile, $scriptContent);

    $process = new Process(['node', $scriptFile, $htmlFile, $pngFile]);
    $process->setTimeout(60);
    $process->run();

    echo "Output: " . $process->getOutput() . "\n";
    if (!$process->isSuccessful()) {
        echo "Error: " . $process->getErrorOutput() . "\n";
        throw new \Exception('Puppeteer failed');
    }

    if (!file_exists($pngFile)) {
        throw new \Exception('Screenshot not created');
    }

    $base64     = base64_encode(file_get_contents($pngFile));
    $chartImage = 'data:image/png;base64,' . $base64;
    echo "Image size: " . filesize($pngFile) . " bytes\n";

    $pdf = Pdf::loadView('charts.event-statistics-pdf-image', [
        'chartData'  => $chartData,
        'chartImage' => $chartImage,
    ])->setPaper('a4', 'landscape');

    $pdf->save('/home/timo/test-manual.pdf');
    echo "PDF generated successfully!\n";

    @unlink($htmlFile);
    @unlink($pngFile);
    @unlink($scriptFile);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
