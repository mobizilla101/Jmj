<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MachinerySubCategoryResource\Pages;
use App\Filament\Resources\MachinerySubCategoryResource\RelationManagers;
use App\Models\MachinerySubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MachinerySubCategoryResource extends Resource
{
    protected static ?string $model = MachinerySubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Ecommerce";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('machinery_category_id')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->directory('machinery_sub_category/logo')
                    ->imageEditor()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
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
            'index' => Pages\ListMachinerySubCategories::route('/'),
            'create' => Pages\CreateMachinerySubCategory::route('/create'),
            'edit' => Pages\EditMachinerySubCategory::route('/{record}/edit'),
        ];
    }
}
