<x-filament-panels::page>
    <form wire:submit="create">
        <div class="flex justify-end gap-4 mb-4">
            <x-filament::button type="submit">
                Registrar movimiento
            </x-filament::button>
            <x-filament::button href="{{ route('filament.admin.resources.materials.create') }}" tag="a"
                color="danger">
                Cancelar
            </x-filament::button>
        </div>
        {{ $this->form }}
    </form>
</x-filament-panels::page>
