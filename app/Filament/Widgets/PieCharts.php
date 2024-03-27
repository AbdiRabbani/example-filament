<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Faculties;
use App\Models\Students;

class PieCharts extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'pieCharts';

    protected static ?int $sort = 2;

    protected static bool $isLazy = false;



    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'PieCharts';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $faculties = Faculties::with('students')->get();
        $fakultas = Faculties::pluck('faculty_name')->toArray();


        $studentCounts = [];

        foreach ($faculties as $faculty) {
            $count = $faculty->students->count();
        
           $studentCounts[] = $count;
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => $studentCounts,
            'labels' => $fakultas,
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
