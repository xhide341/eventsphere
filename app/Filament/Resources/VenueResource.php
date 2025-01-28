<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ImageColumn;


class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Event Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('location')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('capacity')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->disk('public')
                            ->image()
                            ->directory('venues')
                            ->multiple()
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, $set, $record) {
                                if (!empty($state) && is_array($state)) {
                                    collect($state)->each(function ($path, $index) use ($record) {
                                        $record->images()->create([
                                            'path' => $path,
                                            'is_primary' => $index === 0,
                                            'sort_order' => $index
                                        ]);
                                    });
                                }
                            }),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images.path')
                    ->stacked()
                    ->disk('public')
                    ->visibility('public')
                    ->square()
                    ->alignCenter(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('location')
                    ->searchable(),

                TextColumn::make('capacity')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('isAvailable')
                    ->boolean()
                    ->label('Availability')
                    ->alignCenter()
                    ->getStateUsing(fn(Venue $record): bool => $record->isAvailable()),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('availability')
                    ->options([
                        'available' => 'Available',
                        'occupied' => 'Occupied',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'available') {
                            $query->whereDoesntHave('events', function ($query) {
                                $query->where('status', 'ongoing');
                            });
                        } elseif ($data['value'] === 'occupied') {
                            $query->whereHas('events', function ($query) {
                                $query->where('status', 'ongoing');
                            });
                        }
                    })
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('Venue Images')
                    ->schema([
                        ImageEntry::make('images.path')
                            ->label('')
                            ->disk('public')
                            ->visibility('public')
                            ->size(400)
                    ])
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
            'index' => Pages\ListVenues::route('/'),
            'create' => Pages\CreateVenue::route('/create'),
            'edit' => Pages\EditVenue::route('/{record}/edit'),
            'view' => Pages\ViewVenue::route('/{record}'),
        ];
    }
}
