<?php

namespace App\Filament\Resources\BrandResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Brand;


class BrandOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Brands', Brand::query()->count())
            ->descriptionIcon('heroicon-s-cube')
            ->description('Total Brands')
            ->color('grey'),
        ];
    }
}
