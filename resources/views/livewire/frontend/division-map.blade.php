<div class="bg-white p-4 rounded-lg shadow-md text-center space-y-4">
    <h2 class="text-lg font-bold text-black mb-2">এক ক্লিকে বিভাগের খবর</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        {{-- Division --}}
        <select wire:model="selectedDivision"
                class="w-full p-2 border border-gray-300 rounded text-black">
            <option value="">--বিভাগ--</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}">{{ $division->name }}</option>
            @endforeach
        </select>

        {{-- District --}}
        <select wire:model="selectedDistrict"
                class="w-full p-2 border border-gray-300 rounded text-black" 
                @if(empty($districts)) disabled @endif>
            <option value="">--জেলা--</option>
            @foreach($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>

        {{-- Upazila --}}
        <select wire:model="selectedUpazila"
                class="w-full p-2 border border-gray-300 rounded text-black"
                @if(empty($upazilas)) disabled @endif>
            <option value="">--উপজেলা--</option>
            @foreach($upazilas as $upazila)
                <option value="{{ $upazila->id }}">{{ $upazila->name }}</option>
            @endforeach
        </select>
    </div>

    <button wire:click="searchNews"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
        অনুসন্ধান করুন
    </button>
</div>
