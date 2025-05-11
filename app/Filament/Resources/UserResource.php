<?php

namespace App\Filament\Resources;

use App\Enum\UserType;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'System Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                ->disabled()
                ,
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                ->disabled()
                ,
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255)
                ->disabled()
                ,
                Forms\Components\DateTimePicker::make('email_verified_at')
                ->disabled()
                ,
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                ->disabled()
                ,
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                ->disabled()
                ,
                Forms\Components\Select::make('user_type')
                    ->label('Role')
                    ->options( collect(UserType::cases())->mapWithKeys(fn($case) => [$case->value => $case->name])->toArray())
                    ->required(),
                Forms\Components\Select::make('roles')
                    ->label('Assign Roles')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->relationship('roles', 'name')
                    ->helperText('Search and select multiple roles for this user.')
                    ->visible(fn($record) => $record?->user_type === UserType::MANAGEMENT),
                Forms\Components\Select::make('permissions')
                    ->label('Assign Permissions')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->relationship('permissions', 'title')
                    ->helperText('Search and select multiple permissions for this user.')
                    ->visible(fn($record) => $record?->user_type === UserType::MANAGEMENT),
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
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar')->url('avatar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_type')
                ->badge()
                ->label('Role')
                ,
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
