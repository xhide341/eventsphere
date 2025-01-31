<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class FeedbackRelationManager extends RelationManager
{
    protected static string $relationship = 'feedbacks';

    protected static ?string $recordTitleAttribute = 'comment';

    public function table(Table $table): Table
    {
        return $table
            ->queryStringIdentifier('comment')
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->sortable()
                    ->dateTime('d-m-Y'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->mountUsing(function ($form, $record) {
                        $form->fill([
                            'username' => $record->user->name,
                            'rating' => $record->rating,
                            'comment' => $record->comment,
                        ]);
                    })
                    ->form([
                        TextInput::make('username')
                            ->label('User')
                            ->disabled(),
                        TextInput::make('rating')
                            ->label('Rating')
                            ->disabled(),
                        Textarea::make('comment')
                            ->label('Comment')
                            ->disabled()
                    ])
                    ->modalHeading('View Feedback')
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
