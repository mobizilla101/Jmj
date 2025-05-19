<?php

namespace App\Filament\Resources;

use App\Enum\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Ecommerce";

    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::where('orderStatus', OrderStatus::PROCESSING)->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of orders processing';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')->disabled(),
                Forms\Components\TextInput::make('orderStatus')
                    ->required()->disabled(),
                Forms\Components\TextInput::make('transportation_cost')
                ->disabled()
                ,
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()->disabled(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255)->disabled(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255)->disabled(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orderStatus')
                    ->badge()
                    ->color(function($record){
                        return match ($record->orderStatus) {
                        OrderStatus::COMPLETED => 'success',
                        OrderStatus::PROCESSING => 'warning',
                        default => 'danger',
                    };
                    })
                        ,
                        Tables\Columns\TextColumn::make('transportation_cost')
                            ->numeric()
                        ,
                        Tables\Columns\TextColumn::make('total')
                            ->numeric()
                            ->label('Sub-Total')
                            ->sortable(),
                        Tables\Columns\TextColumn::make('')
                            ->numeric()
                            ->label('Total')
                            ->getStateUsing(fn($record)=>$record['total'] + $record['transportation_cost'])
                        ,
                        Tables\Columns\TextColumn::make('address')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('phone')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('user.name')
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
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderDetailsRelationManager::class,
            RelationManagers\PaymentDetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrders::route('/{record}'),
        ];
    }


}
