<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Resources\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;

class ViewEventAttendees extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event-resource.pages.view-event-attendees';

    public Event $event;

    public function mount(Event $record): void
    {
        $this->event = $record;
    }

    public function table(Table $table): Table
    {
        $query = $this->event->users()
            ->select('users.*', 'registrations.registration_date')
            ->getQuery();

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration_date')
                    ->label('Registration Date')
                    ->dateTime()
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('registrations.registration_date', $direction);
                    }),
            ])
            ->defaultSort('registrations.registration_date', 'desc')
            ->striped();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print Attendees')
                ->icon('heroicon-o-printer')
                ->action(fn() => $this->printAttendees()),
        ];
    }

    protected function printAttendees(): void
    {
        // We'll implement the print functionality next
    }
}