<div class="max-w-screen-xl mx-auto">
    <form wire:submit.prevent="submit">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong> Something went wrong:
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-8 p-6 bg-white rounded shadow space-y-4">
                <div>
                    <label class="block font-medium text-sm text-black">News Title</label>
                    <input type="text" wire:model.lazy="news_title" class="w-full border p-2 rounded text-black" />
                </div>

                <div>
                    <label class="block font-medium text-sm text-black">Slug</label>
                    <input type="text" wire:model.lazy="slug" class="w-full border p-2 rounded text-black" />
                </div>

                
                <div>
                    <input type="hidden" id="livewireComponentId" value="{{ $this->getId() }}">

                    <div wire:ignore.self>
                    
                        <textarea wire:model.lazy="news_description" id="news_description_editor" class="w-full border p-2 rounded text-black" rows="6"></textarea>
                    </div>


                </div>


            <!-- Accordion for SEO Meta -->
            <div x-data="{ open: false }" class="border rounded">
                <button type="button" @click="open = !open" class="w-full px-4 py-2 bg-gray-100 text-left font-semibold text-black">
                    SEO Meta Info (Optional)
                </button>
                <div x-show="open" x-collapse class="p-4 space-y-2">
                    <div>
                        <label class="block font-medium text-sm text-black">Meta Title</label>
                        <input type="text" wire:model.lazy="meta_title" class="w-full border p-2 rounded text-black" />
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-black">Meta Description</label>
                        <textarea wire:model.lazy="meta_description" class="w-full border p-2 rounded text-black" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-4 p-6 bg-white rounded shadow space-y-4">
            <div class="flex items-center space-x-4">
                <label class="text-black"><input type="checkbox" wire:model="is_lead" /> Is Lead</label>
                <label class="text-black"><input type="checkbox" wire:model="is_sub_lead" /> Sub-Lead</label>
                <label class="text-black"><input type="checkbox" wire:model="is_premium" /> Premium</label>
            </div>

            <div class="space-y-2">
                

                <!-- Division -->
                <select wire:model="division_id" wire:change="$refresh" class="w-full border p-2 rounded text-black">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>


                <!-- District -->
                <select wire:model="district_id" wire:change="$refresh" class="w-full border p-2 rounded text-black">
                    <option value="">Select District</option>
                    @foreach ($filteredDistricts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>


                <!-- Upazila -->
                <select wire:model="upazila_id" class="w-full border p-2 rounded text-black">
                    <option value="">Select Upazila</option>
                    @foreach ($filteredUpazilas as $upazila)
                        <option value="{{ $upazila->id }}">{{ $upazila->name }}</option>
                    @endforeach
                </select>




        
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold text-lg mb-3 text-black bg-amber-100">Categories</h2>

                <div class="space-y-2 max-h-80 overflow-y-auto">
                    @foreach ($this->categoryTree as $category)
                        <div>
                            <label class="flex items-center space-x-2 text-black">
                                <input type="checkbox" wire:model="selected_categories" value="{{ $category->id }}">
                                <span>{{ $category->name }}</span>
                            </label>

                            @foreach ($category->subcategories as $sub)
                                <div class="pl-6">
                                    <label class="flex items-center space-x-2 text-black">
                                        <input type="checkbox" wire:model="selected_subcategories" value="{{ $sub->id }}">
                                        <span>{{ $sub->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Category Selection -->

            <!-- Tags -->
            <div x-data>
                <label class="block font-medium text-sm text-black">Tags</label>
                <input
                    id="tag-input"
                    type="text"
                    wire:model.lazy="tag_input"
                    @keydown.enter.prevent="$wire.selectTag()"
                    class="w-full border p-2 rounded text-black"
                    placeholder="Type to search or add"
                />


                @if($tag_suggestions && $tag_suggestions->count())
                    <ul class="bg-white border mt-1 rounded shadow max-h-40 overflow-y-auto">
                        @foreach ($tag_suggestions as $suggestedTag)
                            <li wire:click="selectTag('{{ $suggestedTag->name }}')"
                                class="px-3 py-1 cursor-pointer hover:bg-gray-200">
                                <span class="text-black">{{ $suggestedTag->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-2 flex flex-wrap gap-1">
                    @foreach ($selected_tags as $tag)
                        <span class="bg-gray-200 px-2 py-1 rounded text-sm text-black flex items-center">
                            {{ $tag }}
                            <button wire:click="removeTag('{{ $tag }}')" class="ml-1 text-red-500 hover:text-red-700">×</button>
                        </span>
                    @endforeach
                </div>
            </div>



            <!-- Image Upload -->
            <div>
                <label class="block font-medium text-sm text-black">Thumbnail</label>
                <input type="file" wire:model="news_thumbnail" class="w-full text-black" />
                @if ($news_thumbnail)
                    <img src="{{ $news_thumbnail->temporaryUrl() }}" class="mt-2 w-32 h-20 object-cover border rounded" />
                @elseif ($existing_thumbnail)
                    <img src="{{ asset('storage/' . $existing_thumbnail) }}" class="mt-2 w-32 h-20 object-cover border rounded" />
                @endif
            </div>

            <!-- Make sure Alpine.js is loaded in your layout -->
            <div class="space-y-2" x-data="{ status: @entangle('status') }">
                <!-- Status -->
                <label class="text-black">Status</label>
                <select x-model="status" wire:model="status" class="w-full border p-2 rounded text-black">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="scheduled">Scheduled</option>
                </select>

                <!-- Schedule Time (conditionally shown) -->
                <div x-show="status === 'scheduled'" x-transition>
                    <label class="block text-sm text-black mb-1 mt-2">Schedule Time</label>
                    <input
                        type="datetime-local"
                        wire:model.defer="scheduled_at"
                        class="w-full border p-2 rounded text-black"
                        value="{{ $scheduled_at ? \Carbon\Carbon::parse($scheduled_at)->format('Y-m-d\TH:i') : '' }}"
                    />
                </div>
            </div>


            <!-- Submit -->
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                {{ $editing ? 'Update' : 'Publish' }}
                </button>
                    
            </div>
        </div>
    </form>
</div>
@push('scripts')
    <script>
        window.addEventListener('focus-tag-input', () => {
            const input = document.getElementById('tag-input');
            if (input) input.focus();
        });

        window.Livewire.on('toast', ({ type, message }) => {
            showToast(type, message);
        });
    </script>

    <script>
        document.addEventListener('livewire:load', () => {
            const componentId = document.getElementById('livewireComponentId').value;
            window.initTinyEditor('news_description_editor', componentId, 'news_description');
        });

        Livewire.hook('message.processed', (message, component) => {
            const componentId = document.getElementById('livewireComponentId').value;
            // Re-init only if the element still exists (prevent errors)
            if (document.getElementById('news_description_editor')) {
                window.initTinyEditor('news_description_editor', componentId, 'news_description');
            }
        });
    </script>

    <script>
        window.initTinyEditor = function (elementId, componentId, wireModel) {
            tinymce.init({
                selector: '#' + elementId,
                plugins: 'paste lists link image code fullscreen',
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | fullscreen | code',
                menubar: false,
                branding: false,
                height: 300,

                // Strip unwanted HTML tags during paste
                paste_preprocess: function (plugin, args) {
                    const allowedTags = ['b', 'i', 'u', 'strong', 'em'];
                    args.content = args.content.replace(/<(\/?)(\w+)([^>]*)>/gi, function (match, slash, tagName) {
                        return allowedTags.includes(tagName.toLowerCase()) ? match : '';
                    });
                },

                setup: function (editor) {
                    editor.on('change', function () {
                        @this.set(wireModel, editor.getContent());
                    });
                }
            });
        }


    </script>



@endpush

