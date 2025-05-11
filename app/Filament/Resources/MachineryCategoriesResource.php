<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MachineryCategoriesResource\Pages;
use App\Filament\Resources\MachineryCategoriesResource\RelationManagers;
use App\Models\MachineryCategories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MachineryCategoriesResource extends Resource
{
    protected static ?string $model = MachineryCategories::class;

    protected static ?string $navigationGroup = 'Ecommerce';

    protected static ?string $navigationIcon = 'eos-machine-learning-o';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Machinery Categories')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('machineryWorkingNature')
                    ->relationship('machineryWorkingNature','name')
                    ->multiple()
                        ->required()
                    ->searchable()
                    ->preload()
                    ,
                    Forms\Components\FileUpload::make('logo')
                        ->directory('machinery_categories')
                        ->image()
                        ->imageEditor(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('machineryWorkingNature.name')
                ->badge()
                ,
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
            'index' => Pages\ListMachineryCategories::route('/'),
            'create' => Pages\CreateMachineryCategories::route('/create'),
            'edit' => Pages\EditMachineryCategories::route('/{record}/edit'),
        ];
    }
}
