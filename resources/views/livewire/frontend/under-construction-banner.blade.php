<div class="mt-4">
    @if($banner)
        <div class="bg-[rgb(179,25,66)] text-white p-6 text-center shadow-md">
            <div class="text-2xl font-bold mb-4">{{ $banner->banner_text }}</div>
            <div class="text-2xl font-bold mb-4">We will back after:</div>

            <div class="flex justify-center space-x-4 text-white font-bold text-lg">
                <div class="bg-black bg-opacity-70 px-4 py-2 rounded">
                    <div class="text-3xl">{{ $days }}</div>
                    <div>Days</div>
                </div>
                <div class="bg-black bg-opacity-70 px-4 py-2 rounded">
                    <div class="text-3xl">{{ $hours }}</div>
                    <div>Hours</div>
                </div>
                <div class="bg-black bg-opacity-70 px-4 py-2 rounded">
                    <div class="text-3xl">{{ $minutes }}</div>
                    <div>Minutes</div>
                </div>
                <div class="bg-black bg-opacity-70 px-4 py-2 rounded">
                    <div class="text-3xl">{{ $seconds }}</div>
                    <div>Seconds</div>
                </div>
            </div>
        </div>

        <script>
            // Emit Livewire tick every second for real-time countdown
            setInterval(() => {
                Livewire.emit('tick');
            }, 1000);
        </script>
    @endif
</div>
