<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Pages\Salida;
use App\Filament\Resources\MovementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovements extends ListRecords
{
    protected static string $resource = MovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('Entrada')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn (): string => route('filament.admin.pages.ingreso')),
            Actions\Action::make('salida')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('danger')
                ->url(fn (): string => route('filament.admin.pages.salida')),
        ];
    }
}
