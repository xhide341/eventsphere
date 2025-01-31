<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Department;
use App\Models\Speaker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker as FormDatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\DatePicker;
use Filament\Forms\Components\TimePicker;
use App\Rules\VenueHasNoConflictingEvents;


class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Event Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Event Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('description')
                            ->required()
                            ->maxLength(500)
                            ->helperText('Please keep the description concise and to the point. It should be no more than 500 characters.')
                            ->columnSpanFull(),
                        FormDatePicker::make('start_date')
                            ->native(false)
                            ->prefix('Starts')
                            ->required()
                            ->format('d-m-Y')
                            ->minDate(now())
                            ->suffixIcon('heroicon-o-calendar')
                            ->placeholder('Select start date')
                            ->closeOnDateSelection()
                            ->live(),
                        FormDatePicker::make('end_date')
                            ->native(false)
                            ->prefix('Ends')
                            ->required()
                            ->format('d-m-Y')
                            ->suffixIcon('heroicon-o-calendar')
                            ->placeholder('Select end date')
                            ->closeOnDateSelection()
                            ->live(),
                        TimePicker::make('start_time')
                            ->prefix('Starts')
                            ->required()
                            ->format('H:i')
                            ->suffixIcon('heroicon-o-clock')
                            ->native(false)
                            ->live()
                            ->datalist([
                                '08:00',
                                '08:30',
                                '09:00',
                                '09:30',
                                '10:00',
                                '10:30',
                                '11:00',
                                '11:30',
                                '12:00',
                                '12:30',
                                '13:00',
                                '13:30',
                                '14:00',
                                '14:30',
                                '15:00',
                                '15:30',
                                '16:00',
                                '16:30',
                                '17:00',
                                '17:30',
                                '18:00',
                                '18:30',
                                '19:00',
                                '19:30',
                                '20:00',
                                '20:30',
                                '21:00'
                            ]),
                        TimePicker::make('end_time')
                            ->prefix('Ends')
                            ->required()
                            ->format('H:i')
                            ->suffixIcon('heroicon-o-clock')
                            ->native(false)
                            ->live()
                            ->datalist([
                                '08:00',
                                '08:30',
                                '09:00',
                                '09:30',
                                '10:00',
                                '10:30',
                                '11:00',
                                '11:30',
                                '12:00',
                                '12:30',
                                '13:00',
                                '13:30',
                                '14:00',
                                '14:30',
                                '15:00',
                                '15:30',
                                '16:00',
                                '16:30',
                                '17:00',
                                '17:30',
                                '18:00',
                                '18:30',
                                '19:00',
                                '19:30',
                                '20:00',
                                '20:30',
                                '21:00'
                            ]),
                        Select::make('venue_id')
                            ->label('Venue')
                            ->options(Venue::all()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->rule(function ($attribute, $value, $fail) {
                                $startDate = request()->input('start_date');
                                $endDate = request()->input('end_date');
                                $startTime = request()->input('start_time');
                                $endTime = request()->input('end_time');

                                $conflictingEvents = Event::where('venue_id', $value)
                                    ->conflictingWith($startDate, $endDate, $startTime, $endTime)
                                    ->count();

                                if ($conflictingEvents > 0) {
                                    $fail('The venue has conflicting events during the specified timeframe.');
                                }
                            }),
                        Select::make('department_id')
                            ->label('Department')
                            ->options(Department::query()->distinct()->pluck('name', 'id'))
                            ->preload(),
                        Select::make('speaker_id')
                            ->label('Speaker')
                            ->options(Speaker::all()->pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('events')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'Upcoming' => 'Upcoming',
                                'Ongoing' => 'Ongoing',
                                'Completed' => 'Completed',
                                'Archived' => 'Archived',
                            ])
                            ->required()
                            ->default('Upcoming'),
                        TextInput::make('capacity')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('s3')
                    ->defaultImageUrl('/storage/image_placeholder.jpg')
                    ->square(),
                TextColumn::make('name')
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('venue.name')
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('department.name')
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('speaker.name')
                    ->searchable()
                    ->alignCenter(),
                BadgeColumn::make('status')
                    ->alignCenter()
                    ->colors([
                        'success' => 'Completed',
                        'warning' => 'Ongoing',
                        'primary' => 'Upcoming',
                        'danger' => 'Archived',
                    ]),
                TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Registrations')
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Upcoming' => 'Upcoming',
                        'Ongoing' => 'Ongoing',
                        'Completed' => 'Completed',
                        'Archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('venue')
                    ->relationship('venue', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('viewAttendees')
                        ->label('Attendees')
                        ->icon('heroicon-o-users')
                        ->url(fn(Event $record): string => static::getUrl('attendees', ['record' => $record]))
                        ->color('primary'),
                    Tables\Actions\Action::make('archive')
                        ->label('Archive')
                        ->icon('heroicon-o-archive-box-arrow-down')
                        ->action(fn(Event $record) => $record->update(['status' => 'Archived']))
                        ->requiresConfirmation()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'attendees' => Pages\ViewEventAttendees::route('/{record}/attendees'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FeedbackRelationManager::class,
        ];
    }

}
