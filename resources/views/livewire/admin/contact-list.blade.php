<div class="p-6 bg-white rounded shadow">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold text-black">Contacts</h2>
        <input type="text" wire:model="search" placeholder="Search contacts..." class="text-black border px-3 py-2 rounded">
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1 text-black">Name</th>
                <th class="border px-2 py-1 text-black">Email</th>
                <th class="border px-2 py-1 text-black">Phone</th>
                <th class="border px-2 py-1 text-black">Subject</th>
                <th class="border px-2 py-1 text-black">Status</th>
                <th class="border px-2 py-1 text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td class="border px-2 py-1 text-black">{{ $contact->name }}</td>
                    <td class="border px-2 py-1 text-black">{{ $contact->email }}</td>
                    <td class="border px-2 py-1 text-black">{{ $contact->phone ?? '-' }}</td>
                    <td class="border px-2 py-1 text-black">{{ $contact->subject }}</td>
                    <td class="border px-2 py-1 text-black">
                        <span class="{{ $contact->status === 'replied' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($contact->status) }}
                        </span>
                    </td>
                    <td class="border px-2 py-1 flex gap-2">
                        <a href="{{ route('contacts.reply', $contact->id) }}" 
                        class="text-blue-600 hover:underline cursor-pointer" 
                        title="Reply">
                            <flux:icon name="envelope" class="w-5 h-5"/>
                        </a>

                        <button
                            x-data
                            @click.prevent="
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'This contact will be deleted!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if(result.isConfirmed){
                                        $wire.deleteContact({{ $contact->id }})
                                    }
                                })
                            "
                            class="text-red-600 hover:cursor-pointer"
                            title="Delete"
                        >
                            <flux:icon name="trash" class="w-5 h-5"/>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 p-2">No contacts found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $contacts->links() }}

    
</div>
