<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum MovementType: string  implements HasLabel
{
    case entrada = 'entrada';
    case salida = 'salida';
    public function getLabel(): ?string
    {
        return match ($this) {
            self::entrada => 'entrada',
            self::salida => 'salida',
        };
    }
}
