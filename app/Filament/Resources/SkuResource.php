<?php

namespace App\Filament\Resources;

use App\Enum\InventoryType;
use App\Filament\Resources\SkuResource\Pages;
use App\Filament\Resources\SkuResource\RelationManagers;
use App\Models\Sku;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkuResource extends Resource
{
    protected static ?string $model = Sku::class;

    protected static ?string $navigationIcon = 'heroicon-m-archive-box';

    protected static ?string $navigationGroup = "Ecommerce";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information')->schema([
                    // Model Selection
                    Forms\Components\Select::make('model_id')
                        ->relationship('model', 'model_no')  // Relationship with 'model', showing the 'title'
                        ->required()
                        ->reactive()
                        ->searchable()
                        ->getSearchResultsUsing(function ($query, $search) {
                            // Customize the search query to search both 'title' and 'brand' name
                            return $query->where('model_no', 'like', "%{$search}%")  // Search by model's title
                            ->orWhereHas('brand', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");  // Search by brand's name
                            })
                                ->limit(10);  // Optional: Limit the number of search results
                        })
                        ->preload()  // Preload related data for better performance
                        ->getOptionLabelFromRecordUsing(function ($record) {
                            // Customize how each option is displayed in the dropdown
                            return $record->brand->name . " | " . $record->title . " " . $record->model_no;
                        }),

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
            ])

            ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Model Name with Searchable Option
                Tables\Columns\TextColumn::make('model.model_no')
                    ->label('Model')
                    ->sortable()
                    ->searchable(),

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
                // Filter for Model
                Tables\Filters\SelectFilter::make('model_id')
                    ->label('Model')
                    ->relationship('model', 'model_no'),
            ])
            ->actions([
                // Edit Action for each row
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\InventoryRelationManager::class
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkus::route('/'),
            'create' => Pages\CreateSku::route('/create'),
            'edit' => Pages\EditSku::route('/{record}/edit'),
        ];
    }
}
