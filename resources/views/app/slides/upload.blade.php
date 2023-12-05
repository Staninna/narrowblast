<x-app-layout>
    <x-stack-layout>
        <x-headings.area>
            @lang('app.slide_upload')
        </x-headings.area>

        <x-card>
            <h4 class="font-bold">
                Regels voor het maken van een slide:
            </h4>
            <p>
                We willen graag dat de slides die je maakt voor iedereen leuk zijn om te zien. Daarom vertrouwen we erop dat je je aan de volgende regels houdt:
            </p>
            <ul class="list-disc pl-4 flex flex-col gap-1">
                <li>Jouw slide mag grappig zijn, maar niet beledigend</li>
                <li>Geen seksuele of gewelddadige content</li>
                <li>Geen politieke of religieuze boodschappen</li>
                <li>Geen reclame <small>(behalve voor jouw eigen Software Development gerelateerde onderneming)</small></li>
                <li>Deel geen persoonlijke informatie over anderen of jezelf</li>
                <li>Laat geen namen van personen zien zonder expliciete toestemming</li>
                <li>Toon geen content die geheel niet geschikt is voor een jong publiek of een professionele omgeving</li>
            </ul>
            <p>
                Je kunt verwachten dat er tijdens open dagen en andere evenementen strengere regels gelden.
            </p>
            <p>
                <strong>Gebruik naast deze regels ook je gezonde verstand.</strong> Als je twijfelt of een slide wel of niet mag, neem dan contact op met een docent.
            </p>
        </x-card>
        <x-card>
            <h4 class="font-bold">
                Tips voor het maken van een slide:
            </h4>
            <ul class="list-disc pl-4 flex flex-col gap-1">
                <li>Een slide mag maar uit 1 enkel <strong>.html</strong> bestand bestaan</li>
                <li>Test en ontwikkel voor een resolutie van <strong>768x1360 (portret-modus)</strong></li>
                <li>
                    Gebruik <strong>geen externe afbeeldingen</strong>, maar converteer afbeeldingen naar een
                    <x-buttons.link href="https://www.base64-image.de/" target="_blank">base64</x-buttons.link>
                    data URL <x-buttons.link href="https://css-tricks.com/data-uris/" target="_blank">(uitleg)</x-buttons.link>
                </li>
                <li>Gebruik enkel HTML en CSS. Je kunt enkel JavaScript gebruiken als je die later op de slide activeert met een Power-up uit de winkel</li>
                <li>Het mag niet zo zijn dat de content van een slide kan veranderen nadat deze is goedgekeurd. Gebruik geen onbetrouwbare (of eigen) externe API's</li>
                <li>
                    Gebruik deze voorbeeld slides ter referentie:
                    <ul class="list-disc pl-4 flex flex-col">
                        <li><x-buttons.link :href="asset('examples/slide-emoji.html')" target="_blank" download="example.html">simple emoji slide</x-buttons.link></li>
                        <li><x-buttons.link :href="asset('examples/slide-explainer.html')" target="_blank" download="example.html">explainer slide</x-buttons.link></li>
                    </ul>
                </li>
            </ul>
        </x-card>

        <x-card>
            <div class="flex flex-row">
                <div class="flex-1">
                </div>
                <div class="flex-1">
                </div>
            </div>

            @livewire('upload-slide')
        </x-card>
    </x-stack-layout>
</x-app-layout>
