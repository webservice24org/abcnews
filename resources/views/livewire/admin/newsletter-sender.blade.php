<!-- resources/views/livewire/newsletter-sender.blade.php -->
<div class="p-4 bg-white shadow rounded">

    <h2 class="text-xl font-bold text-black">Send Newsletter</h2>

    <div>
        <h3 class="font-semibold text-black">Select Subscribers:</h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach($subscribers as $subscriber)
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="selectedSubscribers" value="{{ $subscriber->id }}">
                    <span class="text-black">{{ $subscriber->name }} ({{ $subscriber->email }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <h3 class="font-semibold text-black">Select News:</h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach($newsPosts as $news)
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="selectedNews" value="{{ $news->id }}">
                    <span class="text-black">{{ $news->news_title }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <button wire:click="sendNewsletter" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
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