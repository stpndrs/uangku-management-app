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
        $months = collect(range(1, 12))->map(function ($month) {
            return sprintf('%02d', $month);
        });

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $data = Transactions::selectRaw('MONTH(date) as month, YEAR(date) as year, COALESCE(SUM(price), 0) as total_amount')
            ->rightJoin(DB::raw("(SELECT '" . implode("' as month UNION SELECT '", $months->toArray()) . "') as months"), function ($join) {
                $join->on('month', '=', DB::raw("MONTH(date)"));
            })
            ->groupBy('year', 'month', 'date')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->pluck('total_amount')->toArray(),
                    'fill' => true
                ],
            ],
            'labels' => $data->map(function ($item, $index) use ($monthNames) {
                $month = $monthNames[$index];
                return $item['year'] . '-' . $month;
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
