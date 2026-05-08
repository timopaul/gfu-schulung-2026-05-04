#!/usr/bin/env node

const puppeteer = require('puppeteer');
const path = require('path');
const fs = require('fs');

async function captureChart(htmlFile, outputFile) {
    let browser;
    try {
        browser = await puppeteer.launch({
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });

        const page = await browser.newPage();

        // Setze eine anständige Viewport-Größe
        await page.setViewport({ width: 1200, height: 600 });

        // Lade die HTML-Datei
        const htmlPath = path.resolve(htmlFile);
        const htmlUrl = `file://${htmlPath}`;

        await page.goto(htmlUrl, { waitUntil: 'networkidle2' });

        // Warte, bis ApexCharts fertig gerendert ist
        await page.waitForFunction(() => {
            const apexChart = document.querySelector('.apexcharts-canvas');
            return apexChart !== null;
        }, { timeout: 10000 });

        // Warte noch kurz für vollständiges Rendering
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Screenshot des Charts
        const chartElement = await page.$('.apexcharts-canvas');
        if (!chartElement) {
            throw new Error('Chart element not found');
        }

        await chartElement.screenshot({ path: outputFile });

        console.log(`Chart captured: ${outputFile}`);
        process.exit(0);
    } catch (error) {
        console.error('Error capturing chart:', error);
        process.exit(1);
    } finally {
        if (browser) {
            await browser.close();
        }
    }
}

// Argumente: node chart-to-image.js <htmlFile> <outputFile>
const htmlFile = process.argv[2];
const outputFile = process.argv[3];

if (!htmlFile || !outputFile) {
    console.error('Usage: node chart-to-image.js <htmlFile> <outputFile>');
    process.exit(1);
}

captureChart(htmlFile, outputFile);

