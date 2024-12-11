<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\TransactionsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\WithdrawsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\PaymentsRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'All Users';

    protected static ?int $navigationSort = 5;




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'active' => 'Active',    // Key as the value stored in the DB, label for display
                        'inactive' => 'Inactive',
                    ]),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->disabled()
                    ->password()
                    ->maxLength(255),
                Forms\Components\Select::make('referral_id')
                    ->relationship('upliner', 'username')
                    ->disabled()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('upliner.username')
                    ->searchable()
                    ->sortable(),



                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),


                    ///
                    Tables\Columns\TextColumn::make('balance')
                    ->label('Balance')
                    ->getStateUsing(function (User $record) {
                        return \Number::currency($record->balance()); // Call your custom method here
                    })
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('investment')
                    ->label('Investment')
                    ->getStateUsing(function (User $record) {
                        return \Number::currency($record->investment()); // Call your custom method here
                    })
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('p2p_withdraw')
                    ->label('P2P & Withdraw')
                    ->getStateUsing(function (User $record) {
                        return \Number::currency($record->withdraw_balance()); // Call your custom method here
                    })
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('all_downline')
                    ->label('Downline')
                    ->getStateUsing(function (User $record) {
                        return $record->allDownline()->count();
                    })
                    ->sortable()
                    ->toggleable(),

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
                Action::make('login')->label('Login')->color('primary')->action(function (User $record) {
                    Auth::login($record);

                    return redirect()->route('user.dashboard.index');
                }),
                Action::make('suspend')->label('Suspend')->color('danger')->action(function (User $record) {
                    $record->status = 'inactive';
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User Suspended Successfully'))
                        ->color('danger')
                        ->send();
                })->visible(fn(User $record): bool => $record->status == 'active'),
                Action::make('activate')->label('Activate')->color('success')->action(function (User $record) {
                    $record->status = 'active';
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User Activated Successfully'))
                        ->color('success')
                        ->send();
                })->visible(fn(User $record): bool => $record->status == 'inactive'),

                // Make PIN
                Action::make('pin')->label('Make PIN')->color('danger')->action(function (User $record) {
                    $record->type = 'pin';
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User Account is now a PIN Account'))
                        ->color('danger')
                        ->send();
                })->visible(fn(User $record): bool => $record->type == 'normal'),

                // Make normal
                Action::make('normal')->label('Make Normal')->color('success')->action(function (User $record) {
                    $record->type = 'normal';
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User Account is now a Normal Account'))
                        ->color('success')
                        ->send();
                })->visible(fn(User $record): bool => $record->type == 'pin'),

                // Block ROI
                Action::make('roi_stop')->label('Stop ROI')->color('danger')->action(function (User $record) {
                    $record->roi_enabled = false;
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User ROI Stopped Successfully'))
                        ->color('danger')
                        ->send();
                })->visible(fn(User $record): bool => $record->roi_enabled == true),

                // start ROI 
                Action::make('roi_start')->label('Start ROI')->color('success')->action(function (User $record) {
                    $record->roi_enabled = true;
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User ROI Started Successfully'))
                        ->color('success')
                        ->send();
                })->visible(fn(User $record): bool => $record->roi_enabled == false),

                // stop ROI Withdraw
                Action::make('stop_roi_withdraw')->label('Stop ROI Withdraw')->color('danger')->action(function (User $record) {
                    $record->roi_withdraw = false;
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User ROI Withdraw Stopped Successfully'))
                        ->color('danger')
                        ->send();
                })->visible(fn(User $record): bool => $record->roi_withdraw == true),

                // stop ROI Withdraw
                Action::make('start_roi_withdraw')->label('Start ROI Withdraw')->color('success')->action(function (User $record) {
                    $record->roi_withdraw = true;
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User ROI Withdraw Started Successfully'))
                        ->color('success')
                        ->send();
                })->visible(fn(User $record): bool => $record->roi_withdraw == false),

                // stop user sale to show on upliner account
                Action::make('stop_sale')->label('Stop Sale')->color('danger')->action(function (User $record) {
                    $record->stop_sale = true;
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User ROI Withdraw Stopped Successfully'))
                        ->color('danger')
                        ->send();
                })->visible(fn(User $record): bool => $record->stop_sale == false),

                // start user sale to show on upliner account
                Action::make('start_sale')->label('Start Sale')->color('success')->action(function (User $record) {
                    $record->stop_sale = false;
                    $record->save();

                    Notification::make()
                        ->title("Action Completed")
                        ->body(__('User ROI Withdraw startped Successfully'))
                        ->color('danger')
                        ->send();
                })->visible(fn(User $record): bool => $record->stop_sale == true),
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
            TransactionsRelationManager::class,
            WithdrawsRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
