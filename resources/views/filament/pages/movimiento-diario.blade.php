<x-filament-panels::page>
    <form wire:submit="createPDF">
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
    <div class="shadow overflow-y-scroll border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">

        <x-table>
            <x-slot name="head">
                <x-th>COD.</x-th>
                <x-th>DESCRIPCION.</x-th>
                <x-th>P.U</x-th>
                <x-th>U.M.</x-th>
                <x-th>ENTRADA / SALIDA</x-th>
                <x-th>O/C</x-th>
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    @if (!$date || $date == \Carbon\Carbon::createFromDate(null, $month, $i)->toDateString())
                        <x-th class="">
                            {{ substr(\Carbon\Carbon::createFromDate(null, $month, $i)->translatedFormat('D'), 0, 1) }}
                            <p class="">{{ $i }}</p>
                        </x-th>
                    @endif
                @endfor
            </x-slot>
            @foreach ($categoriesWithProducts as $category)
                <tr>
                    <x-th>
                        {{ $category->id }}
                    </x-th>
                    <x-th>
                        {{ $category->name }}
                    </x-th>
                    <th <th
                        class="px-6 py-3 text-left text-xs bg-gray-300 font-medium whitespace-nowrap text-gray-500 uppercase
tracking-wider dark:bg-gray-900 dark:text-gray-400"
                        colspan="100%"></th>
                </tr>
                @foreach ($category->materials as $product)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->code }}</td>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->pu }}</td>
                        <td class="px-6 py-4 text-sm font-medium" rowspan="2">{{ $product->um }}</td>
                        <td class="px-6 py-4 text-sm font-medium">Entrada</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-500 bg-gray-200 dark:bg-gray-900 dark:text-gray-400"
                            rowspan="2">
                            {{ $product->order->number }}
                        </td>
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
                        <td
                            class="px-6 py-4 text-sm font-medium text-gray-500 bg-gray-200 dark:bg-gray-900 dark:text-gray-400">
                            Salida
                        </td>
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $date = \Carbon\Carbon::createFromDate(null, $month, $i)->format('Y-m-d');
                                $salidaQuantity = $product->movementproduct
                                    ->where('created_at', '>=', $date . ' 00:00:00')
                                    ->where('created_at', '<=', $date . ' 23:59:59')
                                    ->where('movement.tipo', 'salida')
                                    ->sum('quantity');
                            @endphp
                            <td
                                class="px-6 py-4 text-sm font-medium text-gray-200 bg-gray-200  dark:bg-gray-900 dark:text-gray-400">
                                {{ $salidaQuantity ?: ' ' }}</td>
                        @endfor
                    </tr>
                @endforeach
            @endforeach
        </x-table>

    </div>
</x-filament-panels::page>
