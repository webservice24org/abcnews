<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4 text-black">Subscribers List</h2>

    <table class="min-w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-200 px-4 py-2 text-black">#</th>
                <th class="border border-gray-200 px-4 py-2 text-black">Name</th>
                <th class="border border-gray-200 px-4 py-2 text-black">Email</th>
                <th class="border border-gray-200 px-4 py-2 text-black">Status</th>
                <th class="border border-gray-200 px-4 py-2 text-black">Subscribed At</th>
                <th class="border border-gray-200 px-4 py-2 text-black">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscribers as $index => $subscriber)
                <tr>
                    <td class="border px-4 py-2 text-black">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2 text-black">{{ $subscriber->name }}</td>
                    <td class="border px-4 py-2 text-black">{{ $subscriber->email }}</td>
                    <td class="border p-2">
                    <button wire:click="toggleStatus({{ $subscriber->id }})"
                        class="px-3 py-1 rounded text-white {{ $subscriber->status === 'active' ? 'bg-green-600' : 'bg-red-600' }}">
                        {{ ucfirst($subscriber->status) }}
                    </button>
                </td>

                    <td class="border px-4 py-2 text-black">{{ $subscriber->created_at->format('d M, Y') }}</td>
                    <td class="border px-4 py-2 text-center">
                         <button
                            x-data
                            @click.prevent="
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'This subscriber will be permanently deleted!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.deleteSubscriber({{ $subscriber->id }});
                                    }
                                })
                            "
                            class="text-red-600 hover:text-red-800"
                            title="Delete"
                        >
                            <flux:icon name="trash" class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No subscribers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
