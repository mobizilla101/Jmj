<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MachineryBrandResource\Pages;
use App\Filament\Resources\MachineryBrandResource\RelationManagers;
use App\Models\MachineryBrand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MachineryBrandResource extends Resource
{
    protected static ?string $model = MachineryBrand::class;

    protected static ?string $navigationIcon = 'heroicon-c-square-3-stack-3d';

    protected static ?string $navigationGroup = "Ecommerce";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('logo')
                        ->directory('machinery-brands')
                        ->imageEditor()
                        ->image()
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
            'index' => Pages\ListMachineryBrands::route('/'),
            'create' => Pages\CreateMachineryBrand::route('/create'),
            'edit' => Pages\EditMachineryBrand::route('/{record}/edit'),
        ];
    }
}
