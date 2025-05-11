<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartsCategoryResource\Pages;
use App\Filament\Resources\PartsCategoryResource\RelationManagers;
use App\Models\PartsCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartsCategoryResource extends Resource
{
    protected static ?string $model = PartsCategory::class;

    protected static ?string $navigationIcon = 'bx-category';

    protected static ?string $navigationGroup = 'Ecommerce';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('parts_category')
                    ->options(static::getOptionString())
                    ->allowHtml()
                    ->searchable()

                    ,
                Forms\Components\FileUpload::make('logo')
                    ->required()
                    ->image()
                    ->imageEditor()
                ])
            ]);
    }

    public static function getOptionString()
    {
        return [
            1 => static::selectElement(asset('assets/images/parts/popup-image.png'),1),
            2 => static::selectElement(asset('assets/images/parts/housing.png'),2),
            3 => static::selectElement(asset('assets/images/parts/charging-flex.png'),3),
            4 => static::selectElement(asset('assets/images/parts/antenna.png'),4),
            5 => static::selectElement(asset('assets/images/parts/wireless-charging-flex.png'),5),
            6 => static::selectElement(asset('assets/images/parts/front-camera.png'),6),
            7 => static::selectElement(asset('assets/images/parts/sim-holder.png'),7),
            8 => static::selectElement(asset('assets/images/parts/ear-speaker.png'),8),
            9 => static::selectElement(asset('assets/images/parts/power.png'),9),
            10 => static::selectElement(asset('assets/images/parts/main-speaker.png'),10),
            11 => static::selectElement(asset('assets/images/parts/main-camera.png'),11),
            12 => static::selectElement(asset('assets/images/parts/vibrator.png'),12),
            13 => static::selectElement(asset('assets/images/parts/battery.png'),13),
            14 => static::selectElement(asset('assets/images/parts/mic.png'),14),
            15 => static::selectElement(asset('assets/images/parts/sim-tray.png'),15),
        ];
    }

    public static function selectElement(string $url,int $number=1)
    {
        return "
                <div class='flex items-center'>
                    <p class='me-auto block'>{$number}</p>
                    <img src='{$url}' height='100' width='100' class=' mx-auto' alt='' />
                </div>
               ";
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo'),
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
            'index' => Pages\ListPartsCategories::route('/'),
            'create' => Pages\CreatePartsCategory::route('/create'),
            'edit' => Pages\EditPartsCategory::route('/{record}/edit'),
        ];
    }
}
