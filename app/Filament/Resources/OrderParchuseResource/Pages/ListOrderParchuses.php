<?php

namespace App\Filament\Resources\OrderParchuseResource\Pages;

use App\Filament\Resources\OrderParchuseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderParchuses extends ListRecords
{
    protected static string $resource = OrderParchuseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
