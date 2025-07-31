<div x-data class="space-y-2 bg-white shadow-sm hover:shadow-md transition rounded p-2 mb-2">
    <label class="text-md mb-1 border-b-2 pb-1 font-bold text-black">সংবাদ আর্কাইভ</label>

    <div class="relative" x-data="{
        openPicker() { $refs.archivePicker.showPicker() }
    }">
        <input
            type="date"
            x-ref="archivePicker"
            wire:model.defer="selectedDate"
            wire:change="redirectToArchive"
            class="w-full p-2 pr-10   text-black cursor-pointer "
        />

        <!-- Clickable Calendar Icon -->
        <div
            class="absolute inset-y-0 right-2 flex items-center cursor-pointer"
            @click="openPicker"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 4h10M5 10h14M5 14h14M5 18h14M5 21h14M3 7a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
            </svg>
        </div>
    </div>
</div>
