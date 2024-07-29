<?php

namespace App\Filament\Pages;

use App\Enum\MonthType;
use App\Models\Category;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Valorizado extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.valorizado';
    protected static ?string $navigationParentItem = 'Movimientos';

    public $daysInMonth;
    public $month;
    public $date;
    public $monthName;
    public $categoriesWithProducts;
    public $materials;
    public function mount(): void
    {
        $this->materials = Material::all();
        $this->categoriesWithProducts = Category::where('status', true)->with("materials")->get();
        $this->month = $this->month ?? now()->format('m');
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('month')
                    ->options(MonthType::class)
                    ->native(false)
            ]);
    }
}
