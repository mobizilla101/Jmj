<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MachineryResource\Pages;
use App\Filament\Resources\MachineryResource\RelationManagers;
use App\Models\Machinery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class MachineryResource extends Resource
{
    protected static ?string $model = Machinery::class;

    protected static ?string $navigationIcon = 'iconoir-electronics-chip';

    protected static ?string $navigationGroup = "Ecommerce";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('machinery_brand_id')
                        ->label('Brand')
                        ->relationship('brand', 'name')
                        ->preload()
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn($set) => $set('machinery_working_nature_id', null))
                    ,

                    // Select Working Nature based on Brand
                    Forms\Components\Select::make('machinery_working_nature_id')
                        ->label('Working Nature')
                        ->relationship('workingNature', 'name', function ($query, $get) {
                            $brandId = $get('machinery_brand_id'); // Get selected brand ID (not an array)
                            if (!$brandId) {
                                return $query; // Return base query if no brand is selected
                            }

                            return $query->whereHas('machineryBrands', function ($q) use ($brandId) {
                                $q->where('machinery_brands.id', $brandId); // Ensure correct table reference
                            });
                        })
                        ->preload()
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->disabled(fn($get) => empty($get('machinery_brand_id'))) // Disable if no brand selected
                        ->afterStateUpdated(fn($set) => $set('machinery_category_id', null)),


                    // Select Category based on Working Nature
                    Forms\Components\Select::make('machinery_category_id')
                        ->label('Category')
                        ->relationship('category', 'name',function($query,$get){
                            $workingNatureId = $get('machinery_working_nature_id'); // Get selected brand ID (not an array)
                            if (!$workingNatureId) {
                                return $query; // Return base query if no brand is selected
                            }

                            return $query->whereHas('machineryWorkingNature', function ($q) use ($workingNatureId) {
                                $q->where('machinery_working_natures.id', $workingNatureId); // Ensure correct table reference
                            });
                        }
                        )
                        ->preload()
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->disabled(fn($get) => !$get('machinery_working_nature_id'))
                        ->afterStateUpdated(fn($set) => $set('machinery_sub_category_id', null) // Reset Subcategory when Category changes
                        )
                    , // Disable until working nature is selected

                    // Select Subcategory based on Category
                    Forms\Components\Select::make('machinery_sub_category_id')
                        ->label('Subcategory')
                        ->relationship('subCategory', 'name', fn($query, $get) => $query->where('machinery_category_id', $get('machinery_category_id'))
                        )
                        ->preload()
                        ->searchable()
                        ->reactive()
                        ->disabled(fn($get) => !$get('machinery_category_id')),
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('thumbnail')
                        ->required()
                        ->directory('machinery/thumbnail')
                        ->image()
                        ->imageEditor(),
                    Forms\Components\FileUpload::make('attachments')
                        ->multiple()
                        ->image()
                        ->directory('machinery/attachments')
                        ->imageEditor()
                    ,
                    Forms\Components\TextInput::make('amount')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('discount')
                        ->default(0),
                    Forms\Components\Toggle::make('hot_sale')
                        ->default(false)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('machinery_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('attachments')
                    ->searchable(),
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
                Tables\Actions\Action::make('published')
                    ->label(function ($record) {
                        return $record->published ? "Un-Publish" : "Publish";
                    })
                    ->color(function ($record) {
                        return $record->published ? "danger" : "success";
                    })
                    ->icon(function ($record) {
                        return $record->published ? "heroicon-o-x-circle" : "bi-check-circle";
                    })
                    ->action(function ($record) {
                        $record->published = !$record->published;
                        $record->save();

                    })
                    ->requiresConfirmation()
                ,
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->url(fn($record) => route('machine.preview', $record))
                    ->openUrlInNewTab()
                    ->hidden(fn($record): bool => $record->published ?? false)
                ,
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
            'index' => Pages\ListMachineries::route('/'),
            'create' => Pages\CreateMachinery::route('/create'),
            'edit' => Pages\EditMachinery::route('/{record}/edit'),
        ];
    }
}
