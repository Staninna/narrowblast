<x-app-layout>
    <x-aside-layout>
        <x-stack-layout>
            <x-headings.area>
                @lang('crud.user.your_credits')
            </x-headings.area>

            <div class="grid justify-items-center">
                <div class="relative">
                    <img src="{{ Vite::asset('resources/images/credits-screen.jpg') }}"
                        class="shadow rounded max-w-md w-full object-cover"
                        alt="pars export option">
                    <h2 class="grid justify-items-center pt-[25%] text-2xl font-extrabold absolute inset-0">
                        <span class="">{{ $credits }}</span>
                    </h2>
                </div>
            </div>
        </x-stack-layout>

        <x-stack-layout>
            <x-headings.area>
                @lang('crud.user.claim_credits')
            </x-headings.area>

            <x-card>
                <p>
                    Heb je een credit-code ontvangen van een docent? Gefeliciteerd! Je kunt deze hier inwisselen.
                </p>

                @livewire('credit-redeem-code')
            </x-card>
        </x-stack-layout>
    </x-aside-layout>
</x-app-layout>
