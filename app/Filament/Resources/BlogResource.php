<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'fab-blogger-b';

    protected static ?string $navigationGroup = "Blog";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->hidden(fn(string $operation):bool=>$operation === 'create')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('description')
                        ->required()
                        ->maxLength(255),
                    TinyEditor::make('content')
                    ->required()
                        ->toolbarSticky(true)
                    ,
                    Forms\Components\FileUpload::make('thumbnail')
                        ->image()
                        ->imageEditor()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(20)
                    ->tooltip(fn($record)=>$record->title)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(20)
                    ->tooltip(fn($record)=>$record->description)
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
                    ->url(fn ($record) => route('blog.preview', $record->slug))
                    ->openUrlInNewTab()
                    ->hidden(fn($record):bool=> $record->published)
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
