<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\HomepageSection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomepageManager extends Component
{
    public $sections = [];
    public $categories = [];

    // create/edit modal fields
    public $modalOpen = false;
    public $editingId = null;

    public $title = '';
    public $component = '';
    public $category_id = null;
    public $status = true;

    // Visual options (will be filled in mount)
    public array $componentOptions = [];

    public function mount()
    {
        if (!Auth::check() || Auth::user()->hasRole('Subscriber')) {
            abort(403);
        }

        $this->categories = Category::where('status', 1)->orderBy('name')->get();
        $this->loadSections();

        // Initialize component options with previews from storage/home_preview
        $this->componentOptions = [
            'section-card' => [
                'label' => 'Section Card',
                'preview' => asset('storage/home_preview/section-card.png'),
                'desc' => '1 big + list on the right/left.',
            ],
            'middle-grid-section' => [
                'label' => 'Middle Grid Section',
                'preview' => asset('storage/home_preview/middle-grid.png'),
                'desc' => 'Left/Center/Right + text.',
            ],
            'grid-section-card' => [
                'label' => '3 Column Grid',
                'preview' => asset('storage/home_preview/grid-3col.png'),
                'desc' => 'Clean 3-column card grid.',
            ],
            'middle-grid-section-with-sidebar' => [
                'label' => 'Grid with Sidebar',
                'preview' => asset('storage/home_preview/grid-sidebar.png'),
                'desc' => 'Content + right sidebar.',
            ],
            'middle-lower-grid-section' => [
                'label' => 'Middle + Lower Grid',
                'preview' => asset('storage/home_preview/middle-lower.png'),
                'desc' => 'Hero center + bottom grid.',
            ],
            'culture-trends-section' => [
                'label' => 'Four colum Grid',
                'preview' => asset('storage/home_preview/fourplain.png'),
                'desc' => 'Four plain grid.',
            ],
            'simple-section-card' => [
                'label' => 'Simple Section Card',
                'preview' => asset('storage/home_preview/simple-section.png'),
                'desc' => 'Simple section card.',
            ],
            'four-column-category-section' => [
                'label' => 'Four Column Category',
                'preview' => asset('storage/home_preview/four-col.png'),
                'desc' => 'Four compact columns.',
            ],
            'video-section' => [
                'label' => 'Video Section',
                'preview' => asset('storage/home_preview/video.png'),
                'desc' => 'Latest video block.',
            ],
            'photo-news-section' => [
                'label' => 'Photo News',
                'preview' => asset('storage/home_preview/photo.png'),
                'desc' => 'Photo gallery style.',
            ],
        ];
    }

    public function loadSections()
    {
        $this->sections = HomepageSection::with('category')
            ->orderBy('order')
            ->get();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalOpen = true;
    }

    public function openEditModal($id)
    {
        $section = HomepageSection::findOrFail($id);
        $this->editingId = $section->id;
        $this->title = $section->title;
        $this->component = $section->component;
        $this->category_id = $section->category_id;
        $this->status = (bool) $section->status;
        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'nullable|string|max:255',
            'component' => 'required|string|in:' . implode(',', array_keys($this->componentOptions)),
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'boolean',
        ]);

        $data = [
            'title' => $this->title,
            'component' => $this->component,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ];

        if ($this->editingId) {
            HomepageSection::where('id', $this->editingId)->update($data);
        } else {
            $max = (int) HomepageSection::max('order');
            $data['order'] = $max + 1;
            HomepageSection::create($data);
        }

        $this->modalOpen = false;
        $this->resetForm();
        $this->loadSections();
        $this->dispatch('toast', type: 'success', message: 'Section saved.');
    }

    public function delete($id)
    {
        HomepageSection::findOrFail($id)->delete();
        $this->loadSections();
        $this->dispatch('toast', type: 'success', message: 'Section deleted.');
    }

    public function toggleStatus($id)
    {
        $s = HomepageSection::findOrFail($id);
        $s->status = !$s->status;
        $s->save();
        $this->loadSections();
    }

    // Drag & drop reordering
    public function updateOrder($orderedIds) // receives array of IDs in order
    {
        foreach ($orderedIds as $index => $id) {
            HomepageSection::where('id', $id)->update(['order' => $index]);
        }
        $this->loadSections();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->component = '';
        $this->category_id = null;
        $this->status = true;
    }

    public function render()
    {
        return view('livewire.admin.homepage-manager');
    }
}

