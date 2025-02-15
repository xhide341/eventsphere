<?php

namespace App\Filament\Resources\SpeakerResource\Pages;

use App\Filament\Resources\SpeakerResource;
use App\Filament\Resources\SpeakerResource\Widgets\SpeakerStats;
use Filament\Resources\Pages\ListRecords;

class ListSpeakers extends ListRecords
{
    protected static string $resource = SpeakerResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SpeakerStats::class,
        ];
    }
}
