<?php

namespace App\Filament\Resources\DebtsResource\Pages;

use App\Filament\Resources\DebtsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDebts extends EditRecord
{
    protected static string $resource = DebtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
