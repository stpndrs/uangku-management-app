<?php

namespace App\Filament\Widgets;

use App\Models\Debts;
use App\Models\Savings;
use App\Models\Transactions;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $savings = Savings::all();
        $transactions = Transactions::all();
        $debt = Debts::whereStatus(false)->get();

        $totalSaving = $savings->sum('amount') - $transactions->sum('price');
        $totalTransaction = $transactions->sum('price');
        $totalDebt = $debt->sum('amount');

        return [
            Stat::make('Total Expenses', 'Rp ' . number_format($totalTransaction)),
            Stat::make('Total Savings', 'Rp ' . number_format($totalSaving)),
            Stat::make('Total Debt', 'Rp ' . number_format($totalDebt)),
        ];
    }
}
