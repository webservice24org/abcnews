<div class="max-w-md mx-auto bg-gradient-to-b from-black via-blue-900 to-black text-white p-5 rounded-xl shadow-lg">
    {{-- Search --}}
    <form wire:submit.prevent="searchCity" class="relative mb-3 bg-white flex rounded">
        <input type="text" wire:model="search" placeholder="Enter city..."
               class="w-full px-3 py-2 rounded-l text-black"
               autocomplete="off">

        <button type="submit" class="bg-blue-600 text-white px-4 rounded-r hover:bg-blue-700">
            🔍
        </button>
    </form>

    {{-- Suggestions dropdown --}}
    @if(!empty($suggestions))
        <ul class="absolute z-10 bg-white text-black w-full rounded mt-1 shadow-lg max-h-48 overflow-y-auto">
            @foreach($suggestions as $s)
                <li class="px-3 py-2 cursor-pointer hover:bg-blue-100"
                    wire:click="selectCity('{{ $s['name'] }}')">
                    {{ $s['name'] }}, {{ $s['country'] }}
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Weather & Forecast --}}
    @if($weather && $forecast)
        <h2 class="text-2xl font-bold mb-3">Weather Outlook</h2>
        <div class="flex items-center justify-between bg-blue-800/50 p-4 rounded-lg">
            <div>
                <p class="text-lg font-semibold">{{ $weather['current']['condition']['text'] }}</p>
                <p>{{ $weather['location']['name'] }}, {{ $weather['location']['country'] }}</p>
                <p class="text-sm mt-2">
                    Wind: {{ $weather['current']['wind_kph'] }} kmph ·
                    Precip: {{ $weather['current']['precip_mm'] }} mm ·
                    Pressure: {{ $weather['current']['pressure_mb'] }} mb
                </p>
            </div>
            <div class="text-right">
                <img src="https:{{ $weather['current']['condition']['icon'] }}" class="w-16 h-16 mx-auto">
                <p class="text-3xl font-bold">{{ $weather['current']['temp_c'] }}°C</p>
            </div>
        </div>

        {{-- Forecast Slider --}}
        <div class="mt-4 overflow-x-auto">
            <div class="flex space-x-3">
                @foreach($forecast['forecast']['forecastday'] as $day)
                    <div class="bg-blue-800/40 p-3 rounded-lg text-center min-w-[80px] flex-shrink-0">
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($day['date'])->format('D') }}
                        </p>
                        <img src="https:{{ $day['day']['condition']['icon'] }}" class="w-12 h-12 mx-auto">
                        <p>{{ $day['day']['avgtemp_c'] }}°C</p>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-red-300 mt-3">Weather data unavailable.</p>
    @endif
</div>
