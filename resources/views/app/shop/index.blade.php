<x-app-layout>
    <x-stack-layout>
        <x-headings.area>
            Virtuele Winkel
        </x-headings.area>

        <x-card>
            <p>
                Hier kun je credits gebruiken om tijd op ons Narrowcasting platform te kopen. Je kunt deze tijd gebruiken om je eigen content te laten zien op de schermen in de school.
            </p>
            <p>
                Voordat jouw content op de schermen te zien is moet deze eerst goedgekeurd worden door een docent. Dit kan een paar dagen duren.
            </p>
        </x-card>
        <x-card>
            <x-slot name="header">
                Producten
            </x-slot>

            @livewire('list-shop-items')
        </x-card>
    </x-stack-layout>
</x-app-layout>
