<?php

namespace App\Filament\Pages;

use App\Enum\MonthType;
use App\Models\Category;
use App\Models\Material;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class MovimientoDiario extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.pages.movimiento-diario';
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
        $this->updateDaysInMonth();
        $this->setMonthName();
    }
    public function updatedMonth($value)
    {
        $this->month = $value;
        $this->updateDaysInMonth();
        $this->setMonthName();
        // Reset date if it's not in the selected month
        if ($this->date && \Carbon\Carbon::parse($this->date)->format('m') != $this->month) {
            $this->date = null;
        }
    }
    public function updateDate($value)
    {
        $this->date = $value;
    }
    public function updateDaysInMonth()
    {
        $this->daysInMonth = Carbon::createFromDate(null, $this->month)->daysInMonth;
    }
    protected function setMonthName()
    {
        $this->monthName =
            Carbon::createFromFormat('m', $this->month)->locale('es')->translatedFormat('F');
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Realizar filtro')
                    ->schema([
                        Forms\Components\Select::make('month')
                            ->label('Mes')
                            ->options(MonthType::class)
                            ->searchable()
                            ->reactive()
                            ->native(false),
                        Forms\Components\DatePicker::make('date')
                            ->label('fecha')
                            ->reactive()
                            ->live()

                    ])->columns(2)
            ]);
    }
    public function createPDF()
    {
        Browsershot::url('https://example.com')
            ->setIncludePath('$PATH:/home/linux/.nvm/versions/node/v20.16.0/bin')
            ->save('example.pdf');
        // $pdf = Pdf::view('pdf.movimiento-diario');
        // return $pdf;
    }
}
