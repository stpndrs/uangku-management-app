<?php

namespace App\Filament\Resources\TransactionsResource\Pages;

use App\Filament\Resources\TransactionsResource;
use App\Models\Savings;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactions extends CreateRecord
{
    protected static string $resource = TransactionsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $saving = Savings::find($data['savings_id']);

        if ($saving->remaining_money >= $data['price']) {
            $saving->update([
                'remaining_money' => intval($saving->remaining_money) - intval($data['price'])
            ]);
        }

        return $data;
    }
}
