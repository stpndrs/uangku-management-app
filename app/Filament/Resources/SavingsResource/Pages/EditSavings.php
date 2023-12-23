<?php

namespace App\Filament\Resources\SavingsResource\Pages;

use App\Filament\Resources\SavingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSavings extends EditRecord
{
    protected static string $resource = SavingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
