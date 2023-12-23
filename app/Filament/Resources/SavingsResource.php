<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SavingsResource\Pages;
use App\Filament\Resources\SavingsResource\RelationManagers;
use App\Models\Savings;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SavingsResource extends Resource
{
    protected static ?string $model = Savings::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('source')
                    ->required(),
                TextInput::make('amount')
                    ->numeric()
                    ->required(),
                DatePicker::make('date')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('source')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->sortable()
                    ->searchable()
                    ->money('IDR'),
                TextColumn::make('date')
                    ->sortable()
                    ->searchable()
                    ->date(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSavings::route('/'),
            'create' => Pages\CreateSavings::route('/create'),
            'edit' => Pages\EditSavings::route('/{record}/edit'),
        ];
    }
}
