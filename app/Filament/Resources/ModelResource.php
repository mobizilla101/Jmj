<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModelResource\Pages;
use App\Filament\Resources\ModelResource\RelationManagers;
use App\Models\Model;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ModelResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static ?string $navigationGroup = "Ecommerce";

    protected static ?string $navigationIcon = 'heroicon-c-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information')->schema([
                    Forms\Components\TextInput::make('model_no')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('brand_id')
                        ->relationship('brand', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                    ,

                    Forms\Components\Textarea::make('description')
                        ->required()
                        ->rows(8)
                        ->columnSpanFull(),
                    Forms\Components\Section::make("Specifications")->schema([
                        TinyEditor::make('specifications')
                            ->required()
                            ->toolbarSticky(true)
                    ])->collapsible()
                    ,

                    Forms\Components\DatePicker::make('released')
                        ->label('Release Date')
                    ,

                    Forms\Components\Section::make('Attachable')->schema([

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->image()
                                ->imageEditor()
                                ->required()
                                ->label('Thumbnail Image'),

                            Forms\Components\FileUpload::make('attachments')
                                ->multiple()
                                ->image()
                                ->imageEditor()
                                ->label('Attachments'),
                        ])
                    ])->collapsible()
                    ,
                ]),

                Forms\Components\Section::make("Features")->schema([
                    Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Toggle::make('hot_sale'),
                    Forms\Components\Toggle::make('new'),
                    Forms\Components\Toggle::make('featured'),
                    ])
                ])
                ,

                Forms\Components\Section::make('Key Specifications')
                    ->schema(self::getSpecificationSchema())
                    ->collapsed()
                    ->collapsible()
                ,

            ])
            ;
    }

    protected static function getSpecificationSchema(): array
    {
        return [
            self::specificationGrid('Network', 'network_specification', 'network_active'),
            self::specificationGrid('Body', 'body_specification', 'body_active'),
            self::specificationGrid('Display', 'display_specification', 'display_active'),
            self::specificationGrid('Platform', 'platform_specification', 'platform_active'),
            self::specificationGrid('Memory', 'memory_specification', 'memory_active'),
            self::specificationGrid('Main Camera', 'main_camera_specification', 'main_camera_active'),
            self::specificationGrid('Selfie Camera', 'selfie_camera_specification', 'selfie_camera_active'),
            self::specificationGrid('Sound', 'sound_specification', 'sound_active'),
            self::specificationGrid('Communication', 'communication_specification', 'communication_active'),
            self::specificationGrid('Features', 'feature_specification', 'feature_active'),
            self::specificationGrid('Battery', 'battery_specification', 'battery_active'),
            self::specificationGrid('Test Results', 'test_results_specification', 'test_results_active'),
        ];
    }

    protected static function specificationGrid(string $label, string $specificationField, string $activeField)
    {
        return Forms\Components\Section::make($label)
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Textarea::make($specificationField)
                        ->label($label . ' Specification Content'),
                    Forms\Components\Toggle::make($activeField)
                        ->label('Active'),
                ])
            ])
            ->collapsed();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('released')
                    ->date()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('published')
                ->badge()
                    ->getStateUsing(function($record){
                        return match((bool) $record->published){
                            true=> "Published",
                            false=> "Un-Published",
                            default => ''
                        };
                    })
                    ->color(function($record){
                        return match((bool) $record->published){
                            true=>"success",
                            false=>"danger",
                            default=>""
                        };
                    })
                ->label('Status')
                ,
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
                    ->hidden(fn($record):bool=> $record->published ?? false)
                ,
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ])
            ->defaultSort('id', 'desc')
            ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SkusRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModels::route('/'),
            'create' => Pages\CreateModel::route('/create'),
            'edit' => Pages\EditModel::route('/{record}/edit'),
        ];
    }
}
