<?php

namespace App\Livewire;

use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class ReportMaterial extends Component
{
    public function mount(): void
    {
        $materials = Material::all();
    }

    public function createpdf(Material $material)
    {
        //$materials = Material::all();
        $pdf = Pdf::loadView('pdf.movimiento-diario', compact('material'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'name.pdf');
    }

    public function render()
    {
        return view('livewire.report-material');
    }
}
