<?php

namespace App\Filament\Resources;

use App\Enum\InventoryType;
use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use App\Models\Sku;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $navigationGroup = "Ecommerce";


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information')->schema([

                Forms\Components\Select::make('sku_id')
                    ->relationship('sku', 'id')
                    ->label('SKU')
                    ->required()
                    ->reactive()
                    ->searchable()
                    ->preload()
                    ->getSearchResultsUsing(fn (string $query) => \App\Models\Sku::where('color', 'like', "%{$query}%")
                        ->orWhereHas('model', fn ($q) => $q->where('title', 'like', "%{$query}%"))
                        ->get()
                        ->mapWithKeys(fn ($sku) => [
                            $sku->id => "{$sku->model->model_no} | {$sku->color_name} | {$sku->storage}GB Storage | {$sku->memory}GB Memory",
                        ]))
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        // Customize how each option is displayed in the dropdown
                        return "{$record->model->model_no} | {$record->color_name} | {$record->storage}GB Storage | {$record->memory}GB Memory";
                    })
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $sku = \App\Models\Sku::find($get('sku_id'));
                        if ($sku) {
                            $set('price', $sku->estimated_price);
                        }
                        // Reset color_id when SKU changes
                        $set('color_id', null);
                    })
                ,
                    Forms\Components\Select::make('color_id')
                        ->label('Color')
                        ->required()
                        ->reactive()
                        ->searchable()
                        ->preload()
                        ->options(fn ($get) => $get('sku_id') ?
                            Sku::find($get('sku_id'))->color->pluck('color_name',"id")->toArray()
                            :
                            []
                        )
                        ->getOptionLabelUsing(function ($get) {
                            $sku = Sku::find($get('sku_id'));
                            if (!$sku || !$sku->color) {
                                return "";
                            }

                            $color = $sku->color;
                            return "{$color->color_name} | {$color->color_code}";
                        })

                        ->disabled(fn ($get) => !$get('sku_id'))
                ,
                Forms\Components\Grid::make(2)->schema([

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
//            ->action('create', function (Forms\Actions\CreateAction $action) {
//                $model = $action->getForm()->getModel();
//                $model->save();
//
//                // After saving the first inventory, reset specific fields
//                $action->getForm()->fill([
//                    'imei' => null, // Reset IMEI
//                    'serial_number' => null, // Reset serial number
//                ]);
//
//                // Keep other fields as is
//                // Optional: You could also trigger an event or show a success message
//            });
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku.model.model_no')
                    ->label('Model')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color.color_code')
                ->label('Color')
                ,
                Tables\Columns\TextColumn::make('color.color_name')
                ->label('Color Name')
                ,
                Tables\Columns\TextColumn::make('sku.storage')
                    ->label('Storage')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku.memory')
                    ->label('Memory')
                    ->sortable(),
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
                // Add relevant filters here
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
