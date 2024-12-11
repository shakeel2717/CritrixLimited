<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawResource\Pages;
use App\Filament\Resources\WithdrawResource\RelationManagers;
use App\Models\Withdraw;
use App\Notifications\SendWithdrawApprovalNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class WithdrawResource extends Resource
{
    protected static ?string $model = Withdraw::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

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

                Forms\Components\TextInput::make('wallet')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('fee')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.username')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wallet')
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('fee')
                    ->numeric()
                    ->sortable(),
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
                Action::make('approve')
                    ->label(__('Approve'))
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (Withdraw $withdraw) {
                        $withdraw->status = true;
                        $withdraw->save();
                        // marking all transactions as approved
                        foreach ($withdraw->transactions as $transaction) {
                            $transaction->status = 'approved';
                            $transaction->save();
                            info("Withraw status updated");
                        }

                        $transaction->user->notify(new SendWithdrawApprovalNotification($withdraw));


                        Notification::make()
                            ->title("Wallet")
                            ->body(__('Withdraw approved successfully'))
                            ->color('success')
                            ->send();
                    })->visible(fn(Withdraw $withdraw) => !$withdraw->status),

                Action::make('reject')
                    ->label(__('Reject'))
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->action(function (Withdraw $withdraw) {
                        $withdraw->delete();
                        // marking all transactions as approved
                        foreach ($withdraw->transactions as $transaction) {
                            $transaction->delete();
                            info("Withraw Deleted");
                        }
                        Notification::make()
                            ->title("Wallet")
                            ->body(__('Withdraw Request Deleted successfully'))
                            ->color('success')
                            ->send();
                    })->visible(fn(Withdraw $withdraw) => !$withdraw->status),

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
            'index' => Pages\ListWithdraws::route('/'),
            'create' => Pages\CreateWithdraw::route('/create'),
            'edit' => Pages\EditWithdraw::route('/{record}/edit'),
        ];
    }
}
