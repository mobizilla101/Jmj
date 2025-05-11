<?php

namespace App\Filament\Resources\ModelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkusRelationManager extends RelationManager
{
    protected static string $relationship = 'skus';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information')->schema([
                    // Grid for Color and Picker
                    Select::make('color')
                        ->relationship('color', 'id') // Relationship with the color model
                        ->required()
                        ->multiple()
                        ->options(function () {
                            // Fetch colors and format options with swatches
                            return \App\Models\Colors::all()->mapWithKeys(function ($color) {
                                return [
                                    $color->id => "{$color->color_name} ({$color->color_code})",
                                ];
                            })->toArray();
                        })
                        ->searchable()
                        ->getOptionLabelUsing(function ($value) {
                            // Show a swatch and name in the dropdown
                            $color = \App\Models\Colors::find($value);
                            return $color ? "{$color->color_name} ({$color->color_code})" : null;
                        })
                        ->getSearchResultsUsing(function ($query, $search) {
                            return \App\Models\Colors::where('color_name', 'like', "%{$search}%")
                                ->orWhere('color_code', 'like', "%{$search}%")
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(function ($color) {
                                    return [$color->id => "{$color->color_name} ({$color->color_code})"];
                                });
                        })

                    ,
                    // Grid for Storage and Memory
                    Forms\Components\Grid::make(2)->schema([
                        TextInput::make('storage')
                            ->required()
                            ->numeric()
                            ->placeholder('Storage in GB')
                            ->suffix('GB'),  // Add GB unit next to storage input
                        TextInput::make('memory')
                            ->required()
                            ->numeric()
                            ->placeholder('Memory in GB')
                            ->suffix('GB'),  // Add GB unit next to memory input
                    ]),
                    TextInput::make('discount')->numeric()->default(0),

                    // Estimated Price
                    TextInput::make('price')->default(0)->numeric()->label('Price')->required()
                    ,
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([

                // Color Column with Color Swatch
                Tables\Columns\ColorColumn::make('color.color_code')
                    ->label('Color'),

                // Storage Column with GB suffix
                Tables\Columns\TextColumn::make('storage')
                    ->label('Storage (GB)')
                    ->sortable(),

                // Memory Column with GB suffix
                Tables\Columns\TextColumn::make('memory')
                    ->label('Memory (GB)')
                    ->sortable(),

                // Created At Column (with toggleable visibility)
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Updated At Column (with toggleable visibility)
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Updated At')
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
