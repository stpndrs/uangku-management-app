<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DebtsResource\Pages;
use App\Filament\Resources\DebtsResource\RelationManagers;
use App\Models\Debts;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DebtsResource extends Resource
{
    protected static ?string $model = Debts::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull(),
                DatePicker::make('debt_time')
                    ->required()
                    ->label('The date you owe')
                    ->default(date('Y-m-d')),
                DatePicker::make('due_date')
                    ->required()
                    ->label('The due date of your debt'),
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->html(),
                TextColumn::make('debt_time')
                    ->sortable()
                    ->searchable()
                    ->label('You owe the date')
                    ->date(),
                TextColumn::make('due_date')
                    ->sortable()
                    ->searchable()
                    ->label('Your debt is due on the date')
                    ->date(),
                TextColumn::make('amount')
                    ->sortable()
                    ->searchable()
                    ->money('IDR'),
                CheckboxColumn::make('status')
            ])
            ->defaultSort('debt_time', 'desc')
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
            'index' => Pages\ListDebts::route('/'),
            'create' => Pages\CreateDebts::route('/create'),
            'edit' => Pages\EditDebts::route('/{record}/edit'),
        ];
    }
}
