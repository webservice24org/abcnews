<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4 text-black">Reply to {{ $contact->name }}</h2>

    <div class="mb-4">
        <p class="text-black"><strong>Subject:</strong> {{ $contact->subject }}</p>
        <p class="text-black"><strong>Message:</strong> {{ $contact->message }}</p>
    </div>

    <form wire:submit.prevent="sendReply">
        <div class="mb-4">
            <label class="block font-medium mb-1 text-black">Your Reply</label>
            <textarea wire:model="reply" rows="5"
                class="w-full border-black rounded-lg shadow-sm text-black"></textarea>
            @error('reply') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('contacts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Send Reply</button>
        </div>
    </form>
</div>
