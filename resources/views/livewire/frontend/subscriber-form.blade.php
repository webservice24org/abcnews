<div class="bg-white p-4 rounded-lg shadow-md border">
    @if(session('success'))
        <div class="text-green-600 mb-4 p-2 ">
            {{ session('success') }}
        </div>
    @endif
    <h3 class="text-lg font-semibold mb-3">Subscribe to Newsletter</h3>

    <form wire:submit.prevent="subscribe" class="space-y-3">
        <!-- Name -->
        <div>
            <input type="text" wire:model="name" placeholder="Your Name"
                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div>
            <input type="email" wire:model="email" placeholder="Your Email"
                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Subscribe
        </button>
    </form>
</div>


