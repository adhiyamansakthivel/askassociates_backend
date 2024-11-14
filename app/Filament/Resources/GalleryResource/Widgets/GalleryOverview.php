<?php

namespace App\Filament\Resources\GalleryResource\Widgets;

use App\Models\Gallery;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GalleryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Gallaries', Gallery::query()->count())
            ->description('Total Gallery Images')
            ->descriptionIcon('heroicon-o-photo')
            ->color('grey'),
        ];
    }



}
