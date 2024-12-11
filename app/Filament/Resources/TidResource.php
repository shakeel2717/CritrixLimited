<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TidResource\Pages;
use App\Filament\Resources\TidResource\RelationManagers;
use App\Models\Tid;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TidResource extends Resource
{
    protected static ?string $model = Tid::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tid')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('screenshot')
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
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('screenshot')
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
                // start user sale to show on upliner account
                Action::make('approve')->label('Approved TID')->color('success')->action(function (Tid $record) {

                    $record->status = 'approved';
                    $record->save();

                    // adding balnace transaction
                    $transaction = Transaction::firstOrCreate([
                        'user_id' => $record->user_id,
                        'tid_id' => $record->id,
                        'amount' => $record->amount,
                        'status' => 'approved',
                        'type' => 'deposit',
                        'sum' => true,
                        'reference' => "TID " . $record->tid . " Deposit Approved",
                    ]);

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('The TID has been approved'))
                        ->color('success')
                        ->send();
                })->visible(fn(Tid $record): bool => $record->status == 'pending'),

                // start user sale to show on upliner account
                Action::make('reject')->label('Reject TID')->color('danger')->action(function (Tid $record) {

                    $record->delete();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('The TID has been Rejected'))
                        ->color('success')
                        ->send();
                })->visible(fn(Tid $record): bool => $record->status == 'pending'),

                // start user sale to show on upliner account
                Action::make('viewscreenshot')->label('View Screenshot')->color('success')->action(function (Tid $record) {
                    // redirect user to the screenshot
                    return redirect($record->screenshot);
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
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
            'index' => Pages\ListTids::route('/'),
            'create' => Pages\CreateTid::route('/create'),
            'edit' => Pages\EditTid::route('/{record}/edit'),
        ];
    }
}
