<x-app-layout>
    <x-stack-layout class="flex-grow">
        <x-headings.area>
            NarrowBlast, door Curio Software Developer
        </x-headings.area>
        <x-card>
            <x-slot name="header">
                🚧 Work in progress
            </x-slot>
            <p>
                We zijn op dit moment druk bezig met de ontwikkeling van dit platform. Kom later terug voor meer informatie.
            </p>

            <p>
                In onze <x-buttons.link href="{{ route('shop.index') }}" icon="shopping-cart">virtuele winkel</x-buttons.link> kun je, door tijd te kopen met credits*, jouw eigen gemaakte webpagina op ons Narrowcasting platform laten zien.
                Iedereen die op onze afdeling langs de Narrowcasting schermen loopt, zal jouw pagina zien.
            </p>
        </x-card>
        <x-card>
            <x-slot name="header">
                *Credits Verdienen
            </x-slot>
            <p>
                Op dit moment is maar &eacute;&eacute;n manier om credits voor dit platform te verdienen: veel aanwezig zijn in de lessen. Aan het eind van iedere week krijg je wanneer je <strong>100%</strong> aanwezig bent geweest <strong>100 credits</strong>.
            </p>
        </x-card>
    </x-stack-layout>
    <x-stack-layout>
        <x-headings.area>
            @lang('app.updates')
        </x-headings.area>

        {{-- TODO: Load messages from database instead of hard-coding them --}}
        <x-card background="bg-lime-200">
            <x-slot name="header">
                Status update 1
            </x-slot>
            <p>
                Hier een korte update over de status van het project en wat er de afgelopen tijd is gebeurd.
            </p>
            <p>
                Wat geweldig om te zien dat er al zoveel leuke slides zijn gemaakt! We hebben er al een paar goedgekeurd
                en jullie hebben ze kunnen zien op het scherm bij projectlokaal 216_D.
            </p>
            <p>
                Helaas waren er afgelopen weken ook wat problemen met de techniek, waardoor de schermen niet altijd aan
                stonden, of waardoor er een foutmelding op het scherm stond. Dit komt deels door problemen met het netwerk.
                Onze collega's van de opleiding Systems and Devices helpen ons de komende weken met het oplossen hiervan.
                Thanks y&apos;all!
            </p>
            <p>
                Maar, naast enkele kleine bugs in het systeem, werkt dit op Laravel gebaseerde platform goed genoeg. We
                hopen dat de netwerk-problemen in het nieuwe jaar zijn opgelost. Dan kunnen we
                <a href="https://github.com/curio-team/narrowblast" class="underline" target="_blank">(samen met jullie)</a>
                het platform verder uitbreiden met nieuwe features en het verbeteren van de gebruiksvriendelijkheid.
            </p>
            <p>
                Ter compensatie heb ik zojuist bij het uitdelen van de credits een minimum van 50 credits aangehouden. Dus
                zelfs als je een dagje ziek bent geweest, krijg je toch nog 50 credits. Spend them wisely!
            </p>
            <p>
                Enorm bedankt voor jullie interesse, geduld en feedback!
            </p>
            <x-slot name="footer">
                - Tim om 09:15 op 2 december 2023
            </x-slot>
        </x-stack-layout>
    </x-card>
</x-app-layout>
