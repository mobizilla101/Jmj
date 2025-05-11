<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YoutubeVideoListResource\Pages;
use App\Filament\Resources\YoutubeVideoListResource\RelationManagers;
use App\Models\YoutubeVideoList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YoutubeVideoListResource extends Resource
{
    protected static ?string $model = YoutubeVideoList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = "Our Video List";

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('url')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url'),
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
            'index' => Pages\ListYoutubeVideoLists::route('/'),
            'create' => Pages\CreateYoutubeVideoList::route('/create'),
            'edit' => Pages\EditYoutubeVideoList::route('/{record}/edit'),
        ];
    }
}
