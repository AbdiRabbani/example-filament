<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Faculties;
use App\Models\Students;

class StudentsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

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
                    'label' => 'Blog posts created',
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
