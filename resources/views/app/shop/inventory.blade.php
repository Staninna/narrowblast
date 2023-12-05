<x-app-layout>
    <x-stack-layout>
        <x-headings.area>
            @lang('app.inventory')
        </x-headings.area>

        <x-card>
            <p>
                Hier kun je zien welke producten je hebt gekocht en hoeveel tijd of gebruik van het product nog over is.
            </p>
            <p>
                Om slides actief te zetten moet je eerst een slide uploaden en laten goedkeuren. Ga daarvoor naar je <x-buttons.link href="{{ route('slides.manage') }}" icon="presentation-chart-bar">@lang('app.slides_manage')</x-buttons.link> pagina.
            </p>
        </x-card>

        <x-headings.area>
            @lang('app.inventory_items')
        </x-headings.area>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($items as $item)
                <x-card class="flex flex-col justify-between">
                    <x-slot name="header">
                        {{ $item->name }}
                    </x-slot>

                    <img src="{{ $item->getImageUrl() }}" alt="{{ $item->name }}">

                    <p>
                        {{ $item->description }}
                    </p>

                    {!! $item->showUserData($item->pivot) !!}
                </x-card>
            @endforeach
        </div>
    </x-stack-layout>
</x-app-layout>
