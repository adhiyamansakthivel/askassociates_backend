<?php

namespace App\Filament\Resources\SubCategoryResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SubCategory;


class SubCategoryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Sub Categories', SubCategory::query()->count())
            ->descriptionIcon('heroicon-s-cube-transparent')
            ->description('Total Sub Categories')
            ->color('grey'),
        ];
    }
}
