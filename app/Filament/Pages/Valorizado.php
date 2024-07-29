<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Valorizado extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.valorizado';
    protected static ?string $navigationParentItem = 'Movimientos';
}
