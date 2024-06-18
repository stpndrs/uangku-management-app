<?php

namespace App\Filament\Widgets;

use App\Models\Transactions;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyExpenseGraph extends ChartWidget
{
    protected static ?string $heading = 'Monthly expense graph';

    protected function getData(): array
    {
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [];

        // Calculate the sum of transactions for each month
        foreach ($monthNames as $key => $value) {
            $monthNumber = str_pad($key + 1, 2, '0', STR_PAD_LEFT);
            $data[$value] = Transactions::whereMonth('date', $monthNumber)->whereYear('date', date('Y'))->sum('amount');
        }

        // Convert the $data array to a collection to use the map method
        $dataCollection = collect($data);

        return [
            'datasets' => [
                [
                    'label' => 'Monthly expense graph',
                    'data' => $dataCollection,
                    'fill' => true
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
