<?php
  
namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;


enum ProductStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    case available = 'available';
    case sold_out = 'sold_out';
    case coming_soon = 'coming_soon';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::available => 'success',
            self::sold_out => 'danger',
            self::coming_soon => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::available => 'heroicon-o-check-circle',
            self::sold_out => 'heroicon-o-x-circle',
            self::coming_soon => 'heroicon-o-clock',
        };
    }

    public function getLabel(): ?string
    {
        return Str::headline($this->value);
    }

}