<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Category;

class CategoryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Categories', Category::query()->count())
            ->descriptionIcon('heroicon-s-rectangle-group')
            ->description('Total Categories')
            ->color('grey'),
        ];
    }
}
