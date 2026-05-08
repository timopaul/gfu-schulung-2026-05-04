<?php

namespace App\Services;

class ChartSvgGenerator
{
    public static function generateBarChart(array $months, array $data, array $colors): string
    {
        $maxValue = max($data) > 0 ? max($data) : 1;

        $html = '<div style="margin: 20px 0; background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 4px;">';

        // Container für Balken mit fester Höhe
        $html .= '<div style="display: flex; align-items: flex-end; justify-content: space-around; height: 300px; margin-bottom: 20px; border-bottom: 2px solid #333; position: relative; padding: 0 10px;">';

        foreach ($data as $index => $value) {
            $percentage = ($value / $maxValue) * 100;
            $color = $colors[$index % count($colors)];

            // Balken-Wrapper
            $html .= '<div style="display: flex; flex-direction: column; align-items: center; flex: 1; margin: 0 5px; height: 100%;">';

            // Wert über Balken
            $html .= '<div style="font-size: 12px; font-weight: bold; color: #333; margin-bottom: 5px; height: 20px; display: flex; align-items: center;">' . $value . '</div>';

            // Der Balken selbst (von unten nach oben wachsend)
            $html .= '<div style="width: 100%; max-width: 40px; height: ' . $percentage . '%; background-color: ' . $color . '; border-radius: 3px 3px 0 0; flex-grow: 1; display: flex; align-items: flex-end;"></div>';

            // Monatslabel unter Balken
            $html .= '<div style="font-size: 12px; font-weight: bold; color: #333; width: 100%; text-align: center; margin-top: 5px;">' . $months[$index] . '</div>';

            $html .= '</div>';
        }

        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }
}

