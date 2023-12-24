<?php

namespace App\Filament\Resources\TransactionsResource\Pages;

use App\Filament\Resources\TransactionsResource;
use App\Models\Savings;
use App\Models\Transactions;
use Exception;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class EditTransactions extends EditRecord
{
    protected static string $resource = TransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $saving = Savings::find($data['savings_id']);

        if ($record->saving_id === $data['saving_9d']) {
            if ($record->price !== $data['price']) {
                if ($record->price > $data['price']) {
                    $saving->update([
                        'remaining_money' => $saving->remaining_money + ($record->price - $data['price'])
                    ]);
    
                    $record->update($data);
                } else if ($saving->remaining_money >= $data['price']) {
                    $saving->update([
                        'remaining_money' => $saving->remaining_money - $data['price']
                    ]);
    
                    $record->update($data);
                } else {
                    Notification::make()
                        ->danger()
                        ->title('The remaining savings selected are insufficient!')
                        ->body('Choose another savings source that still has a remaining balance.')
                        ->persistent()
                        ->send();
    
                    $this->halt();
                }
            }
        } else {
            $oldSaving = Savings::find($record->saving_id);

            $oldSaving->update([
                'remaining_money' => $oldSaving->remaining_money - $data['price']
            ]);

            $saving->update([
                'remaining_money' => $saving->remaining_money + ($record->price - $data['price'])
            ]);

            $record->update($data);
        }


        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
