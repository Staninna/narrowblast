<div>
    <form wire:submit="create" class="flex flex-col gap-4">
        {{ $this->form }}

        <x-buttons.primary submit big>
            Upload
        </x-buttons.primary>
    </form>

    <x-filament-actions::modals />
</div>
