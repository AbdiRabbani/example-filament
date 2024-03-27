<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Faculties;

class StudentsChart extends ChartWidget
{

    protected static ?int $sort = 3;

    protected static bool $isLazy = false;
    

    protected function getData(): array
    {
        $faculties = Faculties::with('students')->get();
        $fakultas = Faculties::pluck('faculty_name')->toArray();


        $studentCounts = [];

        foreach ($faculties as $faculty) {
            $count = $faculty->students->count();
        
           $studentCounts[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'The number of students',
                    'data' => $studentCounts,
                ],
            ],
            'labels' => $fakultas,
        ];
    }

    protected function getType(): string    
    {
        return 'bar';
    }
}
