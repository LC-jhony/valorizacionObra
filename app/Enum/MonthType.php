<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum MonthType: string implements HasLabel
{
    case Enero = "01";
    case Febrero = "02";
    case Marzo = "03";
    case Abril = "04";
    case Mayo = "05";
    case Junio = "06";
    case Julio = "07";
    case Agosto = "08";
    case Septiembre = "09";
    case Octubre = "10";
    case Noviembre = "11";
    case Diciembre = "12";

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Enero => "Enero",
            self::Febrero => "Febrero",
            self::Marzo => "Marzo",
            self::Abril => "Abril",
            self::Mayo => "Mayo",
            self::Junio => "Junio",
            self::Julio => "Julio",
            self::Agosto => "Agosto",
            self::Septiembre => "Septiembre",
            self::Octubre => "Octubre",
            self::Noviembre => "Noviembre",
            self::Diciembre => "Diciembre",
        };
    }
}
