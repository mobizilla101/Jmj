<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartsResource\Pages;
use App\Filament\Resources\PartsResource\RelationManagers;
use App\Models\Parts;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nette\Utils\Image;

class PartsResource extends Resource
{
    protected static ?string $model = Parts::class;

    protected static ?string $navigationIcon = 'gmdi-inventory-o';

    protected static ?string $navigationGroup = 'Ecommerce';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information')->schema([

                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('parts_category_id')
                        ->relationship('partsCategory', 'name')
                        ->required()
                        ->reactive()
                        ->searchable()
                        ->getSearchResultsUsing(function ($query, $search) {
                            // Customize the search query to search both 'title' and 'brand' name
                            return $query->where('name', 'like', "%{$search}%")  // Search by model's title
                            ->limit(10);  // Optional: Limit the number of search results
                        })
                        ->preload()
                    ,
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
                    Forms\Components\Textarea::make('description')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('€ '),
                    Forms\Components\TextInput::make('stock')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('discount')
                        ->required()
                        ->numeric(),
                    Forms\Components\Toggle::make('hot_sale')
                        ->default(false)
                ]),
                Forms\Components\Section::make('Images')->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->directory('parts/thumbnail')
                        ->image()
                        ->imageEditor()
                    ,
                    Forms\Components\FileUpload::make('attachments')
                        ->directory('parts/attachments')
                        ->image()
                        ->imageEditor()
                        ->multiple()
                    ,
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model.model_no')
                    ->label('Model')
                    ->searchable()
                    ->sortable()
                ,
                Tables\Columns\TextColumn::make('partsCategory.name')
                    ->label('Parts Category')
                    ->sortable()
                ,
                Tables\Columns\ImageColumn::make('thumbnail')
                ,
                Tables\Columns\ImageColumn::make('attachments')
                ,
                Tables\Columns\TextColumn::make('price')
                    ->money('npr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
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
                    ->url(fn ($record) => route('parts.preview', $record))
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
            'index' => Pages\ListParts::route('/'),
            'create' => Pages\CreateParts::route('/create'),
            'edit' => Pages\EditParts::route('/{record}/edit'),
        ];
    }
}
