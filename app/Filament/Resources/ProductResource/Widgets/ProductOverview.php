<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Products', Product::query()->count())
            ->description('Total Products')
            ->descriptionIcon('heroicon-s-bolt')
            ->color('grey'),
            Stat::make('Products', Product::query()->where('status', 'available')->count())
            ->description('Available Products')
            ->descriptionIcon('heroicon-o-check-circle')
            ->color('success'),
            Stat::make('Products', Product::query()->where('status', 'sold_out')->count())
            ->description('Sold Out Products')
            ->descriptionIcon('heroicon-o-x-circle')
            ->color('danger'),
            Stat::make('Products', Product::query()->where('status', 'coming_soon')->count())
            ->description('Available Soon Products')
            ->descriptionIcon('heroicon-o-clock')
            ->color('warning'),
        ];
    }
}
