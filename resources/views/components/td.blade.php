@props(['align' => 'left'])
@php
    $textAlignClass =
        [
            'left' => 'text-left',
            'light' => 'text-right',
            'center' => 'text-center',
        ][$align] ?? 'text-left';
@endphp
<td class="px-6 py-4 text-sm font-medium dark:text-white {{ $textAlignClass }}">
    {{ $slot }}
</td>
