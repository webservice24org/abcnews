<div class="bg-white p-6 rounded-lg shadow max-w-5xl mx-auto px-4 py-4">
    @if (session()->has('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block mb-1 font-medium">Your Name</label>
            <input type="text" wire:model="name" class="w-full border rounded px-3 py-2">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Your Email</label>
            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Phone Number</label>
            <input type="text" wire:model="phone" class="w-full border rounded px-3 py-2">
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Subject</label>
            <input type="text" wire:model="subject" class="w-full border rounded px-3 py-2">
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Message</label>
            <textarea wire:model="message" rows="5" class="w-full border rounded px-3 py-2"></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Send Message
        </button>
    </form>
</div>
