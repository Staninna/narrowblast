@props([
    'background' => 'bg-white',
])
<x-stack-layout {{
    $attributes->class([
        'shadow-md md:rounded p-4',
        $background,
    ])
}}>
    @isset($header)
        <div class="font-bold">
            <x-headings.section>
                {{ $header }}
            </x-headings.section>
        </div>
    @endisset

    <x-stack-layout class="flex-grow">
        {{ $slot }}
    </x-stack-layout>

    @isset($footer)
        <div class="border-t border-gray-800 text-sm text-gray-800 italic pt-4">
            {{ $footer }}
        </div>
    @endisset
</x-stack-layout>
