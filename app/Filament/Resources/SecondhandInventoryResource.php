<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SecondhandInventoryResource\Pages;
use App\Models\SecondhandInventory;
use App\Models\Sku;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Nette\Utils\Image;

class SecondhandInventoryResource extends Resource
{
    protected static ?string $model = SecondhandInventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $navigationLabel = 'Secondhand Inventory';
    protected static ?string $pluralModelLabel = 'Secondhand Inventories';
    protected static ?string $navigationGroup = "Ecommerce";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information')->make([
                    Select::make('sku_id')
                        ->relationship('sku', 'id')
                        ->label('SKU')
                        ->required()
                        ->reactive()
                        ->searchable()
                        ->preload()
                        ->getSearchResultsUsing(fn(string $query) => \App\Models\Sku::where('color', 'like', "%{$query}%")
                            ->orWhereHas('model', fn($q) => $q->where('title', 'like', "%{$query}%"))
                            ->get()
                            ->mapWithKeys(fn($sku) => [
                                $sku->id => "{$sku->model->model_no} | {$sku->color_name} | {$sku->storage}GB Storage | {$sku->memory}GB Memory",
                            ]))
                        ->getOptionLabelFromRecordUsing(function ($record) {
                            // Customize how each option is displayed in the dropdown
                            return "{$record->model->model_no} | {$record->color_name} | {$record->storage}GB Storage | {$record->memory}GB Memory";
                        })
                        ->afterStateUpdated(function ($state, $set, $get) {
                            $sku = \App\Models\Sku::find($get('sku_id'));
                            if ($sku) {
                                $set('amount', $sku->price);
                            }
                            // Reset color_id when SKU changes
                            $set('color_id', null);
                        })
                    ,

                    Select::make('color_id')
                        ->label('Color')
                        ->required()
                        ->reactive()
                        ->searchable()
                        ->preload()
                        ->options(fn($get) => $get('sku_id') ?
                            Sku::find($get('sku_id'))->color->pluck('color_name', "id")->toArray()
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
                        ->disabled(fn($get) => !$get('sku_id')),

                    Grid::make(2)->schema([
                        TextInput::make('imei')
                            ->required()
                            ->numeric()
                            ->minLength(15)
                            ->maxLength(15),
                        TextInput::make('serial_number')
                            ->required()
                            ->label('Serial Number')
                    ]),
                    DatePicker::make('purchase_date')
                        ->required()
                        ->label('Purchase Date'),
                    Textarea::make('description')
                        ->label('Description'),
                    Grid::make(2)->schema([
                        TextInput::make('discount')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->label('Discount (%)'),
                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->label('Amount'),
                    ]),
                    Grid::make(2)->schema([
                        Toggle::make('refurbed')
                            ->label('Refurbed'),
                        Toggle::make('hot_sale')
                        ->label('Hot Sale')
                    ]),
                    Grid::make(2)->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->directory('secondhand-inventory/thumbnails')
                        ,
                        FileUpload::make('attachments')
                            ->image()
                            ->imageEditor()
                            ->multiple()
                            ->directory('secondhand-inventory/attachments'),
                    ])
                ])
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(components: [
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('sku.model.model_no')
                    ->label('Model')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color.color_code')
                    ->label('Color')
                ,
                Tables\Columns\ImageColumn::make('thumbnail')
                ,
                Tables\Columns\ImageColumn::make('attachments'),
                TextColumn::make('refurbed')
                    ->badge()
                    ->color(fn($record) => $record->refurbed ? 'success' : 'danger')
                    ->label('refurbed')
                    ->formatStateUsing(fn($record) => $record->refurbed ? 'refurbed' : 'Not refurbed')
                    ->searchable()
                ,
                TextColumn::make('imei')
                    ->label('IMEI')
                    ->searchable(),
                TextColumn::make('serial_number')
                    ->label('Serial Number')
                    ->searchable(),
                TextColumn::make('purchase_date')
                    ->label('Purchase Date')
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Discount (%)')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->badge()
                ,
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('refurbed')
                    ->label('refurbed Status')
                    ->trueLabel('refurbed')
                    ->falseLabel('Not refurbed')
                    ->attribute('refurbed'),
            ])
            ->actions([
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
            // Add related resources or managers if applicable
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSecondhandInventories::route('/'),
            'create' => Pages\CreateSecondhandInventory::route('/create'),
            'edit' => Pages\EditSecondhandInventory::route('/{record}/edit'),
        ];
    }
}
