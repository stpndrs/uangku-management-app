<?php

namespace App\Filament\Resources\SavingsResource\Pages;

use App\Filament\Resources\SavingsResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSavings extends ListRecords
{
    protected static string $resource = SavingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            // 'all' => Tab::make(),
            // 'active' => Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('active', true)),
            // 'inactive' => Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('active', false)),
        ];
    }
}
