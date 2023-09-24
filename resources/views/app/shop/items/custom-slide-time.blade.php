<div class="relative pt-1">
    @php
        $asPercentage = floor($timeUsedInHours / $timeTotalInHours * 100);
    @endphp
    <div class="flex mb-2 items-center justify-between">
        <div>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200">
                {{ $timeUsedInHours }} / {{ $timeTotalInHours }} uur gebruikt
            </span>
        </div>
        <div class="text-right">
            <span class="text-xs font-semibold inline-block text-pink-600">
                {{ $asPercentage }}%
            </span>
        </div>
    </div>
    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-pink-200">
        <div style="width:{{ $asPercentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"></div>
    </div>
</div>
