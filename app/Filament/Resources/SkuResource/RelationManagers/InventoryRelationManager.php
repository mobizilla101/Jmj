<?php

namespace App\Filament\Resources\SkuResource\RelationManagers;

use App\Models\Sku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryRelationManager extends RelationManager
{
    protected static string $relationship = 'inventory';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Select::make('color_id')
                            ->label('Color')
                            ->required()
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->options(fn ($get) => $this->getSkuColors())
                            ->disabled(fn ($get) => !$this->getSkuId()),
                        Forms\Components\TextInput::make('imei')
                            ->required()
                            ->numeric()
                            ->minLength(15)
                            ->maxLength(15)
                        ,
                        Forms\Components\TextInput::make('serial_number')
                            ->required(),
                    ])
                ]),
            ]);
    }

    private function getSkuId(): ?int
    {
        return $this->ownerRecord->id ?? null;
    }

    private function getSkuColors(): array
    {
        $skuId = $this->getSkuId();
        if (!$skuId) {
            return [];
        }

        // Fetch SKU colors dynamically
        $sku = Sku::with('color')->find($skuId);
        return $sku?->color->pluck('color_name', 'id')->toArray() ?? [];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('imei')
            ->columns([
                Tables\Columns\ColorColumn::make('color.color_code')
                    ->label('Color Code')
                ,
                Tables\Columns\TextColumn::make('color.color_name')
                    ->label('Color Name')
                ,
                Tables\Columns\TextColumn::make('imei')
                    ->searchable()
                ,
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
