<?php

namespace App\Filament\Resources\BrandResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModelsRelationManager extends RelationManager
{
    protected static string $relationship = 'models';

    public function form(Form $form): Form
    {
        return $form
            ->schema([ Forms\Components\Section::make('Information')->schema([
                Forms\Components\TextInput::make('model_no')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->rows(8)
                    ->columnSpanFull(),
                Forms\Components\Section::make("Specifications")->schema([

                    Forms\Components\RichEditor::make('specifications')
                        ->toolbarButtons([
                            'bold',
                            'edit',
                            'preview',
                        ])
                        ->enableToolbarButtons([
                            'h3'
                        ])->label('')
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

                Forms\Components\Section::make('Key Specifications')
                    ->schema(self::getSpecificationSchema())
                    ->collapsed()
                    ->collapsible()
                ,
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('model_no')
            ->columns([
                Tables\Columns\TextColumn::make('model_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('released')
                    ->date()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('thumbnail'),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
}
