<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccessoryResource\Pages;
use App\Filament\Resources\AccessoryResource\RelationManagers;
use App\Models\Accessory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Laravel\Prompts\clear;

class AccessoryResource extends Resource
{
    protected static ?string $model = Accessory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Ecommerce";

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('brand_id')
                    ->searchable()
                    ->preload()
                    ->relationship('brand', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('category_id', null);
                        $set('working_nature_id', null);
                        $set('sub_category_id',null);
                    }),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->relationship('category','name',function($query,$get){
                        $brand_id = $get('brand_id'); // Get selected brand ID (not an array)
                        if (!$brand_id) {
                            return $query; // Return base query if no brand is selected
                        }

                        return $query->whereHas('brands', function ($q) use ($brand_id) {
                            $q->where('accessory_brands.id', $brand_id); // Ensure correct table reference
                        });
                    })
                    ->disabled(fn($get) => !$get('brand_id'))
                ,
                Forms\Components\Select::make('sub_category_id')
                    ->label('Sub Category')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->relationship('subCategory','name',function($query,$get){
                        $category_id = $get('category_id'); // Get selected brand ID (not an array)
                        if (!$category_id) {
                            return $query; // Return base query if no brand is selected
                        }

                        return $query->where('category_id',$category_id);
                    })
                    ->disabled(fn($get) => !$get('category_id'))
            ,
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->imageEditor()
                    ->directory('accessories/thumbnail')
                ,
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->directory('accessories/attachments')
                ,

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Toggle::make('hot_sale')
                        ->default(false),
                    Forms\Components\Toggle::make('new')
                        ->default(false),
                ]),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('discount')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('hot_sale'),
                Tables\Columns\ToggleColumn::make('new'),
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
                    ->label(function($record){
                        return $record->published ? "Un-Publish" : "Publish";
                    })
                    ->color(function($record){
                        return $record->published ? "danger" : "success";
                    })
                    ->icon(function($record){
                        return $record->published ? "heroicon-o-x-circle" : "bi-check-circle";
                    })
                    ->action(function($record){
                        $record->published = ! $record->published;
                        $record->save();

                    })
                    ->requiresConfirmation()
                ,
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->url(fn ($record) => route('accessories.preview', $record))
                    ->openUrlInNewTab()
                    ->hidden(fn($record):bool=> $record->published ?? false)
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
            'index' => Pages\ListAccessories::route('/'),
            'create' => Pages\CreateAccessory::route('/create'),
            'edit' => Pages\EditAccessory::route('/{record}/edit'),
        ];
    }
}
