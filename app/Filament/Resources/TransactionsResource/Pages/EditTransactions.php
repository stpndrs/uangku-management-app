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

        if ($record->savings_id === $data['savings_id']) {
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
            $oldSaving = Savings::find($record->savings_id);

            $savingRemainingMoney = $saving->remaining_money - $data['price'];
            $oldSavingRemainingMoney = $oldSaving->remaining_money + $data['price'];

            # Jika harga lama tidak sama dengan harga baru
            if ($record->price != $data['price']) {
                $hargaLama = $record->price; // harga lama
                $savingOldSaldo = $oldSaving->remaining_money; // saldo di tabungan lama
                $hargaBaru = $data['price'];
    
                $a = $savingOldSaldo + $hargaLama;
                $b = $hargaBaru - $hargaLama;
                $oldSavingRemainingMoney = $a + $b;
            }

            $saving->update([
                'remaining_money' => $savingRemainingMoney
            ]);

            $oldSaving->update([
                'remaining_money' => $oldSavingRemainingMoney
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
