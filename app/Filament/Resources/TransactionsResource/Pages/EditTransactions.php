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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
