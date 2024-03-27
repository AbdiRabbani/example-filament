<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

use App\Models\Faculties;

use function PHPSTORM_META\type;

class duobleCharts extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'duobleCharts';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $maxHeight = '300px';

    protected static ?int $sort = 1;


    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'duobleCharts';

    protected static bool $isLazy = false;

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


        $studentCounts1 = [];
        $studentCounts2 = [];
        $studentCounts3 = [];

        foreach ($faculties as $faculty) {
            $countMale = 0;
            $countFemale = 0;
        
            foreach ($faculty->students as $student) {
                if ($student->jk == 'Laki') {
                    $countMale++;
                } elseif ($student->jk == 'Perempuan') {
                    $countFemale++;
                }
            }
        
            $studentCounts1[] = $countMale;
            $studentCounts2[] = $countFemale;
            $studentCounts3[] = $countMale + $countFemale;

        }

        return [
            'chart' => [
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Male Students',
                    'type' => 'bar',
                    'data' => $studentCounts1,
                ],[
                    'name' => 'Female Students',
                    'type' => 'bar',
                    'data' => $studentCounts2,
                ],[
                    'name' => 'Total Students',
                    'type' => 'line',
                    'data' => $studentCounts3,
                ],
            ],
            'xaxis' => [
                'categories' => $fakultas,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b', '#220BF5', '#F50B0B'],
        ];
    }
}
