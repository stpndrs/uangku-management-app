<?php

namespace App\Filament\Resources\DebtsResource\Pages;

use App\Filament\Resources\DebtsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDebts extends ListRecords
{
    protected static string $resource = DebtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
