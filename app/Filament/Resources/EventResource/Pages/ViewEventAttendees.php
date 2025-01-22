<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Resources\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

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
                ImageColumn::make('avatar')
                    ->getStateUsing(fn($record) => $record->avatar)
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration_date')
                    ->label('Registration Date')
                    ->dateTime('M d, Y g:i A')
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
                ->action(function () {
                    try {
                        $attendees = $this->event->users()
                            ->select('users.*', 'registrations.registration_date')
                            ->get();

                        $pdf = Pdf::setOptions([
                            'isRemoteEnabled' => true,
                            'chroot' => base_path('vendor/iamcal/php-emoji/lib')
                        ])->loadView('filament.resources.event-resource.pdf.event-attendees', [
                                    'event' => $this->event,
                                    'attendees' => $attendees,
                                ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, "event-{$this->event->id}-attendees.pdf");
                    } catch (\Exception $e) {
                        \Log::error('PDF Generation Error:', [
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw $e;
                    }
                }),
        ];
    }
}