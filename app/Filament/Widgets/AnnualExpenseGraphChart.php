<?php

namespace App\Filament\Widgets;

use App\Models\Transactions;
use Filament\Widgets\ChartWidget;

class AnnualExpenseGraphChart extends ChartWidget
{
    protected static ?string $heading = 'Annual expense graph';

    protected function getData(): array
    {
        $data = Transactions::selectRaw('YEAR(date) as year, COALESCE(SUM(amount), 0) as total_amount')
            ->groupBy('year')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Annual expenditure transaction graph',
                    'data' => $data->pluck('total_amount')->toArray(),
                    'fill' => true
                ],
            ],
            'labels' => $data->pluck('year')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
