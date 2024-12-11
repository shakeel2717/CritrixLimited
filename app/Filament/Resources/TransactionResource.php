<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'username')
                    ->searchable() // Makes the dropdown searchable
                    ->required(),
                Forms\Components\TextInput::make('payment_id')
                    ->numeric(),
                Forms\Components\TextInput::make('user_plan_id')
                    ->numeric(),
                Forms\Components\TextInput::make('withdraw_id')
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'approved' => 'Approved',
                    ])
                    ->default('approved') // Set the default in the form schema
                    ->required(),
                Forms\Components\Toggle::make('sum')
                    ->default(true)
                    ->required(),
                Forms\Components\Textarea::make('reference')
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'deposit' => 'Deposit',
                        'withdraw' => 'Withdraw',
                        'daily profit' => 'Daily Profit',
                        'reward' => 'Reward',
                        'balance adjustment' => 'Balance Adjustment'
                    ])
                    ->default('deposit') // Set the default in the form schema
                    ->required(),
                Forms\Components\TextInput::make('additional_type')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.username')
                ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment.txn_id')
                ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_plan_id')
                ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('withdraw_id')
                ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\IconColumn::make('sum')
                    ->boolean(),
                Tables\Columns\TextColumn::make('type')->searchable(),
                Tables\Columns\TextColumn::make('additional_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
