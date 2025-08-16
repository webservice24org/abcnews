<div class="p-6 bg-white shadow rounded space-y-4">
    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label class="block font-medium text-sm text-black">Page Title</label>
            <input type="text" wire:model.lazy="title" class="w-full border p-2 rounded text-black" />
        </div>

        <div class="mb-3 text-black">
            <label class="form-label text-black">Content</label>
            <livewire:jodit-text-editor 
                wire:model.live="description" 
                :buttons="[
                    'bold', 'italic', 'ul', 'ol', 'left', 'center', 'right', 'font', 'fontsize', 'paragraph',
                    'table', 'link', 'brush', 'undo', 'redo', 'image'
                ]"
                :config="[
                    'height' => 700,
                    'uploader' => [
                        'insertImageAsBase64URI' => true
                    ],
                    'image' => [
                        'editSrc' => true,
                        'useImageTitle' => true,
                        'useImageAlt' => true
                    ]
                ]"
            />
        </div>

        <div class="mb-3">
            <label class="form-label text-black">Layout Type</label>
            <select wire:model="layout_type" class="w-full border p-2 rounded text-black">
                <option value="no-sidebar">No Sidebar</option>
                <option value="right-sidebar">Right Sidebar</option>
            </select>
        </div>

        <button class="p-1 bg-blue-500 text-white" type="submit">Update</button>
    </form>
</div>
