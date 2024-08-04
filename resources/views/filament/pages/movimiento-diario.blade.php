<x-filament-panels::page>
    <form wire:submit="createPDF" id="pdfForm">
        <div class="flex justify-end mb-4">
            <x-filament::button type="submit" icon="heroicon-o-document" color="success">Crear
                reporte</x-filament::button>
        </div>
        {{ $this->form }}
    </form>
    <x-filament::card>
        <div class="flex items-center justify-end gap-2">
            Mes:<p class="uppercase">{{ $monthName }}</p>
        </div>
    </x-filament::card>
    <div class="shadow overflow-y-scroll border-b 
    border-gray-200 dark:border-gray-700 sm:rounded-lg">
        <x-table>
            <x-slot name="head">
                <x-th>Cod.</x-th>
                <x-th>Descripcion</x-th>
                <x-th>p.u.</x-th>
                <x-th>u.m</x-th>
                <x-th>ingreso y <br /> egreso</x-th>
                <x-th>o/c</x-th>
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    <x-th>
                        {{ substr(\Carbon\Carbon::createFromDate(null, $month, $i)->translatedFormat('D'), 0, 1) }}
                        <p>{{ $i }}</p>
                    </x-th>
                @endfor
            </x-slot>
            @foreach ($categoriesWithProducts as $category)
                <tr>
                    <x-th>{{ $category->id }}</x-th>
                    <x-th align="lefth">{{ $category->name }}</x-th>
                    <x-th colspan="100%"></x-th>
                </tr>
                @foreach ($category->materials as $product)
                    <tr>
                        <x-td rowspan="2">{{ $product->code }}</x-td>
                        <x-td rowspan="2">{{ $product->name }}</x-td>
                        <x-td rowspan="2">{{ $product->pu }}</x-td>
                        <x-td rowspan="2">{{ $product->um }}</x-td>
                        <x-td>Entrada</x-td>
                        <x-th rowspan="2"> {{ $product->order->number }}</x-th>
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $date = \Carbon\Carbon::createFromDate(null, $month, $i)->format('Y-m-d');
                                $entradaQuantity = $product->movementproduct
                                    ->where('created_at', '>=', $date . ' 00:00:00')
                                    ->where('created_at', '<=', $date . ' 23:59:59')
                                    ->where('movement.tipo', 'entrada')
                                    ->sum('quantity');
                            @endphp
                            <x-td>{{ $entradaQuantity ?: ' ' }}</x-td>
                        @endfor
                    </tr>
                    <tr>
                        <x-th>Salida</x-th>
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $date = \Carbon\Carbon::createFromDate(null, $month, $i)->format('Y-m-d');
                                $salidaQuantity = $product->movementproduct
                                    ->where('created_at', '>=', $date . ' 00:00:00')
                                    ->where('created_at', '<=', $date . ' 23:59:59')
                                    ->where('movement.tipo', 'salida')
                                    ->sum('quantity');
                            @endphp
                            <x-th> {{ $salidaQuantity ?: ' ' }}</x-th>
                        @endfor
                    </tr>
                @endforeach
            @endforeach
        </x-table>
    </div>

</x-filament-panels::page>
