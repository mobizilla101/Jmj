<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MachineryWorkingNatureResource\Pages;
use App\Filament\Resources\MachineryWorkingNatureResource\RelationManagers;
use App\Models\MachineryWorkingNature;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MachineryWorkingNatureResource extends Resource
{
    protected static ?string $navigationGroup = 'Ecommerce';

    protected static ?string $model = MachineryWorkingNature::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\Select::make('machineryBrands')
                        ->label('Brands')
                        ->relationship('machineryBrands', 'name') // Many-to-many relationship
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->options(function () {
                            return \App\Models\MachineryBrand::all()->mapWithKeys(function ($brand) {
                                return [$brand->id => $brand->name]; // Format: [id => name]
                            })->toArray();
                        })
                        ->getOptionLabelUsing(function ($value) {
                            $brand = \App\Models\MachineryBrand::find($value);
                            return $brand ? $brand->name : null;
                        })
                        ->getSearchResultsUsing(function ($query, $search) {
                            return \App\Models\MachineryBrand::where('name', 'like', "%{$search}%")
                                ->limit(10)
                                ->get()
                                ->mapWithKeys(function ($brand) {
                                    return [$brand->id => $brand->name];
                                });
                        })
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('machineryBrands.name')
                ->badge()
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
            'index' => Pages\ListMachineryWorkingNatures::route('/'),
            'create' => Pages\CreateMachineryWorkingNature::route('/create'),
            'edit' => Pages\EditMachineryWorkingNature::route('/{record}/edit'),
        ];
    }
}
