<div class="bg-white p-4 rounded-lg shadow-md text-center space-y-4 max-w-5xl mx-auto px-4 py-4">
    <h2 class="text-lg font-bold text-black mb-2">আমার এলাকার খবর</h2>

    <div class="gap-3">
        {{-- Division --}}
        <select wire:model="division_id" wire:change="$refresh" class="w-full border mb-1 p-2 rounded text-black">
            <option value="">Select Division</option>
            @foreach ($divisions as $division)
                <option value="{{ $division->id }}">{{ $division->name }}</option>
            @endforeach
        </select>


        <!-- District -->
        <select wire:model="district_id" wire:change="$refresh" class="w-full mb-1 border p-2 rounded text-black">
            <option value="">Select District</option>
            @foreach ($filteredDistricts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>


        <!-- Upazila -->
        <select wire:model="upazila_id" class="w-full border p-2 rounded text-black">
            <option value="">Select Upazila</option>
            @foreach ($filteredUpazilas as $upazila)
                <option value="{{ $upazila->id }}">{{ $upazila->name }}</option>
            @endforeach
        </select>
    </div>

    <button wire:click="searchNews"
            class=" hover:cursor-pointer text-white px-4 py-2 rounded transition" style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }}; color:{{$color->cat_btn_color ?? '#e7000b'}}">
        অনুসন্ধান করুন
    </button>
</div>
