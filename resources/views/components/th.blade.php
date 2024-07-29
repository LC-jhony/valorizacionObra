@props(['align' => 'left'])
@php
    $textAlignClass =
        [
            'left' => 'text-left',
            'light' => 'text-right',
            'center' => 'text-center',
        ][$align] ?? 'text-left';
@endphp
<th class="px-6 py-3 text-xs bg-gray-300 font-medium whitespace-nowrap text-gray-500 uppercase
tracking-wider dark:bg-gray-900 dark:text-gray-400{{ $textAlignClass }}"
    {{ $attributes }}>
    {{ $slot }}
</th>
