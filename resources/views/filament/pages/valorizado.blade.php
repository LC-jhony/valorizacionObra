@php
    $totalSalidaQuantity = 0;
@endphp

<x-filament-panels::page>
    <form wire:submit"createPDF">
        <div class="flex justify-end mb-4">
            <x-filament::button icon='heroicon-o-document' color='success'>Crear reporte</x-filament::button>
        </div>
        {{ $this->form }}
    </form>
    <div class="shadow overflow-y-scroll border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-th rowspan="2">COD.
                    </x-th>
                    <x-th rowspan="2">
                        DESCRIPCION</x-th>
                    <x-th rowspan="2">P.U</x-th>
                    <x-th rowspan="2">U.M</x-th>
                    <x-th rowspan="2">INGRESO
                        Y EGRSO</x-th>
                    <x-th rowspan="2">O/C
                    </x-th>
                    <x-th colspan="2" align="center">MES
                        ANTERIOR</x-th>
                    <x-th colspan="2" align="center">MES
                        ACTUAL</x-th>
                    <x-th colspan="2" align="center">
                        ACUMULADO</x-th>
                    <x-th colspan="2" align="center">SALDO
                    </x-th>

                </tr>
                <tr>
                    <x-th>CANTIDAD</x-th>
                    <x-th>VALORIZADO</x-th>
                    <x-th>CANTIDAD</x-th>
                    <x-th>VALORIZADO</x-th>
                    <x-th>CANTIDAD</x-th>
                    <x-th>VALORIZADO</x-th>
                    <x-th>CANTIDAD</x-th>
                    <x-th>VALORIZADO</x-th>
                </tr>
            </x-slot>
            @foreach ($categoriesWithProducts as $category)
                <tr>
                    <x-th>
                        {{ $category->id }}
                    </x-th>
                    <x-th>
                        {{ $category->name }}
                    </x-th>
                    <x-th colspan="100%"></x-th>
                </tr>
                @foreach ($category->materials as $product)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->code }}</td>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->pu }}</td>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->um }}</td>
                        <td class="px-6 py-4 text-sm font-medium">Entrada</td>
                        <x-th
                            class="px-6 py-4 text-sm font-medium text-gray-500 bg-gray-200 dark:bg-gray-900 dark:text-gray-400"
                            rowspan="2">
                            {{ $product->order->number }}
                        </x-th>
                        <x-td align="center">2</x-td>
                    </tr>

                    <tr>
                        <x-th
                            class="px-6 py-4 text-sm font-medium text-gray-500 bg-gray-200 dark:bg-gray-900 dark:text-gray-400">
                            Salida
                        </x-th>
                        <x-th>5</x-th>
                    </tr>
                @endforeach
            @endforeach
        </x-table>
    </div>
</x-filament-panels::page>
