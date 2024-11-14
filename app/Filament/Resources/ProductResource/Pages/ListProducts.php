<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\ProductStatusEnum;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Widgets\ProductOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;


class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
           ProductOverview::class
        ];
    }


    public  function getTitle(): string
    {
        return "Manage Products";
    }


    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            ...collect(ProductStatusEnum::cases())
                ->mapWithKeys(
                    fn (ProductStatusEnum $status) => [
                        $status->value => Tab::make($status->value)
                            ->query(fn ($query) => $query->where('status', $status))
                            ->label($status->getLabel())
                            ->icon($status->getIcon()),
                    ]
                )
                ->toArray(),
        ];
    }
}
