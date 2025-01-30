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
                Tables\Actions\DeleteAction::make(),
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->mountUsing(fn($form, $record) => $form->fill([
                        'user.name' => $record->user->name,
                        'rating' => $record->rating,
                        'comment' => $record->comment,
                    ]))
                    ->form([
                        TextInput::make('user.name')
                            ->label('User')
                            ->default($this->record->user->name)
                            ->disabled(),
                        TextInput::make('rating')
                            ->label('Rating')
                            ->default($this->record->rating)
                            ->disabled(),
                        Textarea::make('comment')
                            ->label('Comment')
                            ->default($this->record->comment)
                            ->disabled(),
                    ])
                    ->modalHeading('View Feedback')
                    ->modalWidth('lg'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
