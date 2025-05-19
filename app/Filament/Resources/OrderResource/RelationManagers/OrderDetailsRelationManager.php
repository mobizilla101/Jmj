<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\CartFormatters\OrderDetailFormatter;
use App\Models\Cart;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class OrderDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderDetails'; // This should match the method name in the Order model

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Image')
                    ->getStateUsing(fn($record) => OrderDetailFormatter::format($record)['img'] ?? null)
                    ->url(fn($record) => OrderDetailFormatter::format($record)['img'] ?? null),

                Tables\Columns\TextColumn::make('')
                    ->label('Item Name')
                    ->getStateUsing(fn($record) => OrderDetailFormatter::format($record)['model_no'] ?? '-'),
                Tables\Columns\TextColumn::make('storage')
                    ->label('Storage (GB)')
                    ->sortable()
                    ->getStateUsing(fn($record) => OrderDetailFormatter::format($record)['storage'] ?? "-")
                ,
                Tables\Columns\TextColumn::make('memory')
                    ->label('Memory (GB)')
                    ->getStateUsing(fn($record) => OrderDetailFormatter::format($record)['memory'] ?? '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->getStateUsing(fn($record) => OrderDetailFormatter::format($record)['amount'] ?? 0),
                Tables\Columns\TextColumn::make('quantity')->numeric(),
                Tables\Columns\TextColumn::make('discount')->numeric()->formatStateUsing(fn($state) => $state . '%'),
                Tables\Columns\TextColumn::make('total')->label('Total'),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Color')
                    ->getStateUsing(fn($record) => OrderDetailFormatter::format($record)['color']['color_code'] ?? '#FFFFFF')
                    ->sortable(),
            ])
            ->filters([ /* Add filters if needed */])
            ->actions([

            ])
            ->bulkActions([
            ]);
    }
}
