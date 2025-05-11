<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Enum\PaymentStatus;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'payment_details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_id')
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                ->numeric()
                ->label('Total')
                ,
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn($record)=>match($record->status){
                    PaymentStatus::PROCESSING => 'warning',
                    PaymentStatus::PENDING => 'warning',
                    PaymentStatus::COMPLETED => 'success',
                    default => 'danger'
                }),
                TextColumn::make('provider_name')
                ->label('Payment Type')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('Complete')
                ->button()
                ->color('success')
                ->requiresConfirmation('Mark this payment as complete?')
                ->hidden(fn($record)=>$record->status === PaymentStatus::COMPLETED)
                ->action(fn($record)=>$record->update(['status'=>PaymentStatus::COMPLETED]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
