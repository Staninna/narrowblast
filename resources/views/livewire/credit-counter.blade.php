<x-stack-layout row class="items-center bg-amber-300 hover:text-gray-200 hover:bg-black @isset($center) justify-center @endif">
    <a href="{{ route('shop.credits') }}" class="flex flex-col items-center gap-1 py-2 px-4">
        <span class="text-xs italic underline">Bekijk balans</span>
        <div class="flex items-center gap-1">
            <x-icons.credits />
            <span class="font-bold">{{ $credits }}</span>
            <span class="hidden md:inline">@lang('app.credits')</span>
        </div>
    </a>
</x-stack-layout>
