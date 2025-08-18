<div class="p-4 bg-white shadow rounded h-[80vh] flex flex-col gap-4">

    <h2 class="text-xl font-bold text-black">Send Newsletter</h2>

    <!-- Subscribers Section (Scrollable, 50% height) -->
    <div class="flex-1 overflow-y-auto border rounded p-2">
        <h3 class="font-semibold text-black mb-2">Select Subscribers:</h3>
        <div class="space-y-1">
            @foreach($subscribers as $subscriber)
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="selectedSubscribers" value="{{ $subscriber->id }}">
                    <span class="text-black text-sm">{{ $subscriber->name }} ({{ $subscriber->email }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- News Section (Paginated, 50% height) -->
    <div class="flex-1 overflow-y-auto border rounded p-2">
        <h3 class="font-semibold text-black mb-2">Select News:</h3>
        <div class="space-y-1">
            @foreach($newsPosts as $news)
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="selectedNews" value="{{ $news->id }}">
                    <span class="text-black text-sm">{{ $news->news_title }}</span>
                </label>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $newsPosts->links() }}
        </div>
    </div>

    <!-- Send Button -->
    <div>
        <button wire:click="sendNewsletter" 
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Send Newsletter
        </button>
    </div>

</div>

@push('scripts')
<script>
    window.Livewire.on('toast', ({ type, message }) => {
        showToast(type, message); 
    });
</script>
@endpush
