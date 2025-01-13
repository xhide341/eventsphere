<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\LatestEvents;
use App\Filament\Widgets\PopularVenues;
use App\Filament\Widgets\EventAttendanceChart;
use App\Filament\Widgets\DepartmentEventsChart;
use App\Filament\Widgets\TopSpeakers;

class Dashboard extends \Filament\Pages\Dashboard
{
    public static ?string $navigationIcon = 'heroicon-o-home';

    public function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            DepartmentEventsChart::class,
            EventAttendanceChart::class,
            LatestEvents::class,
            PopularVenues::class,
            TopSpeakers::class,
        ];
    }
}