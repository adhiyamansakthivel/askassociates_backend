<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BrandResource\Widgets\BrandOverview;
use App\Filament\Resources\CategoryResource\Widgets\CategoryOverview;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverView extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Brands', Brand::query()->count())
            ->descriptionIcon('heroicon-s-cube')
            ->description('Total Brands')
            ->color('grey'),
            Stat::make('Categories', Category::query()->count())
            ->descriptionIcon('heroicon-s-rectangle-group')
            ->description('Total Categories')
            ->color('grey'),
            Stat::make('Sub Categories', SubCategory::query()->count())
                ->description('Total Sub Categories')
                ->descriptionIcon('heroicon-s-cube-transparent')
                ->color('grey'),
            // Stat::make('Products', Product::query()->count())
            //     ->description('Total Products')
            //     ->descriptionIcon('heroicon-s-bolt')
            //     ->color('grey'),
           
            Stat::make('Users', User::query()->count())
            ->description('Total Users')
            ->descriptionIcon('heroicon-s-users')
            ->color('grey'),
            Stat::make('Gallaries', Gallery::query()->count())
            ->description('Total Gallery Images')
            ->descriptionIcon('heroicon-o-photo')
            ->color('grey'),
        ];
    }
}
