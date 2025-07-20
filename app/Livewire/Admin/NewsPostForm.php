<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\{
    NewsPost, Division, District, Upazila,
    Category, SubCategory, Tag
};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsPostForm extends Component
{
    use WithFileUploads;

    protected function checkPermission()
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'User not authenticated.');
        }

        $action = $this->editing ? 'edit news' : 'create news';

        // Map roles to allowed actions
        $rolePermissions = [
            'Super Admin' => ['create news', 'edit news', 'update news', 'delete news'],
            'Admin' => ['create news', 'edit news', 'update news', 'delete news'],
            'Editor' => ['create news', 'edit news', 'update news'],
            'Seo Expert' => ['edit news'],
            'Reporter' => ['create news', 'edit news'],
            'Subscriber' => ['read news'],
        ];

        $userRoles = $user->getRoleNames(); // Collection of role names

        $hasPermission = $userRoles->contains(function ($role) use ($rolePermissions, $action) {
            return isset($rolePermissions[$role]) && in_array($action, $rolePermissions[$role]);
        });

        if (! $hasPermission) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }


    
    



    public $editing = false;
    // Form Fields
    public $news_title, $slug, $news_description;
    public $meta_title, $meta_description;
    public $division_id, $district_id, $upazila_id;
    public $category_id, $subcategory_id;
    public $is_lead = false, $is_sub_lead = false, $is_premium = false;
    public $status = 'draft', $scheduled_at;



    // File
    public $news_thumbnail;
    public $existing_thumbnail;

    // Tags
    public $tag_input = '';
    public $tag_suggestions = [];
    public $selected_tags = [];

    public $selected_categories = [];
    public $selected_subcategories = [];


    public $newsPostId = null; // For editing

    public function getCategoryTreeProperty()
    {
        return Category::with('subcategories')->get();
    }



    public function updatedCategoryId($value)
    {
        $this->subcategory_id = null;
    }

    public function getFilteredDistrictsProperty()
    {
        return $this->division_id
            ? District::where('division_id', $this->division_id)->get()
            : collect();
    }

    public function getFilteredUpazilasProperty()
    {
        return $this->district_id
            ? Upazila::where('district_id', $this->district_id)->get()
            : collect();
    }



      public function updatedDivisionId($value)
    {
        $this->district_id = null;
        $this->upazila_id = null;

        $this->dispatch('$refresh'); // force re-render if necessary
    }


        public function updatedDistrictId($value)
{
    $this->upazila_id = null;

    $this->dispatch('$refresh'); // force re-render of upazila dropdown
}



public $allSubcategories;





    public function mount($id = null)
    {
        $this->editing = $id ? true : false;
        $this->checkPermission();
        if ($id) {
            $this->post = NewsPost::with('subcategories')->findOrFail($id);
            $this->selected_subcategories = $this->post->subcategories->pluck('id')->toArray();
            $this->allSubcategories = SubCategory::all();

            $this->editing = true;
            $post = NewsPost::with('tags')->findOrFail($id);
            $this->newsPostId = $post->id;
            $this->news_title = $post->news_title;
            $this->slug = $post->slug;
            $this->news_description = $post->news_description;
            $this->meta_title = $post->meta_title;
            $this->meta_description = $post->meta_description;
            $this->division_id = $post->division_id;
            $this->district_id = $post->district_id;
            $this->upazila_id = $post->upazila_id;
            $this->selected_categories = $post->categories->pluck('id')->toArray();
            $this->selected_subcategories = $this->post->subcategories->pluck('id')->toArray();
            //$this->selected_subcategories = $post->subcategories->pluck('id')->toArray();

           // $this->category_id = $post->categories->pluck('id')->first(); // assuming one
            //$this->subcategory_id = $post->subcategories->pluck('id')->first();
            $this->is_lead = $post->is_lead;
            $this->is_sub_lead = $post->is_sub_lead;
            $this->is_premium = $post->is_premium;
            $this->status = $post->status;
            //$this->scheduled_at = $post->scheduled_at;
            if ($post->status === 'scheduled' && $post->scheduled_at) {
                $this->scheduled_at = \Carbon\Carbon::parse($post->scheduled_at)->format('Y-m-d\TH:i');
            }
            $this->existing_thumbnail = $post->news_thumbnail;

            $this->selected_tags = $post->tags->pluck('name')->toArray();
        }
    }

    

    public function selectTag($tagName = null)
    {
        $tagName = $tagName ?? trim($this->tag_input);

        if (!$tagName) return; // Don't add empty tag

        if (!in_array($tagName, $this->selected_tags)) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $this->selected_tags[] = $tag->name;
        }

        $this->tag_input = '';
        $this->tag_suggestions = [];

        $this->dispatch('focus-tag-input');
    }




    public function removeTag($tagName)
    {
        $this->selected_tags = array_filter($this->selected_tags, function ($tag) use ($tagName) {
            return $tag !== $tagName;
        });
    }


    public function updatedTagInput()
    {
        if (strlen($this->tag_input) > 1) {
            $this->tag_suggestions = Tag::where('name', 'like', '%' . $this->tag_input . '%')
                ->whereNotIn('name', $this->selected_tags)
                ->limit(5)
                ->get();
        } else {
            $this->tag_suggestions = collect();
        }
    }




    public function updatedNewsTitle()
    {
        $this->slug = Str::slug($this->news_title);
    }

    public function submit()
    {
        $this->checkPermission();
        $validated = $this->validate([
            'news_title' => 'required|string|max:255',
            'slug' => 'required|unique:news_posts,slug,' . $this->newsPostId,
            'news_description' => 'required|string',
            'selected_categories' => 'required|array|min:1',
            'selected_subcategories' => 'array',
            'selected_subcategories.*' => 'exists:sub_categories,id',
            'status' => 'required|in:draft,published,scheduled',
            'scheduled_at' => $this->status === 'scheduled' ? 'required|date' : 'nullable|date',

            'news_thumbnail' => $this->newsPostId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        // Continue if validation passes
        $thumbnailName = $this->existing_thumbnail;
        if ($this->news_thumbnail) {
            $thumbnailName = $this->news_thumbnail->store('news', 'public');
            if ($this->existing_thumbnail) {
                Storage::disk('public')->delete($this->existing_thumbnail);
            }
        }

        $data = [
            'news_title' => $this->news_title,
            'slug' => $this->slug,
            'news_description' => $this->news_description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'division_id' => $this->division_id,
            'district_id' => $this->district_id,
            'upazila_id' => $this->upazila_id,
            'news_thumbnail' => $thumbnailName,
            'is_lead' => $this->is_lead,
            'is_sub_lead' => $this->is_sub_lead,
            'is_premium' => $this->is_premium,
            'status' => $this->status,
            'scheduled_at' => $this->status === 'scheduled' ? $this->scheduled_at : null,
            'user_id' => Auth::id(),
        ];

        $post = NewsPost::updateOrCreate(['id' => $this->newsPostId], $data);

        $post->categories()->sync($this->selected_categories);
        $post->subcategories()->sync($this->selected_subcategories ?? []);

        

        $tagIds = [];
        foreach ($this->selected_tags as $name) {
            $tag = Tag::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);

        // Show toast only after success
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $this->newsPostId ? 'Post updated successfully!' : 'Post created successfully!',
        ]);

        // Then redirect after short delay
        return redirect()->route('news.index');
    }


        public function render()
    {
        return view('livewire.admin.news-post-form', [
            'divisions' => Division::all(),
            'filteredDistricts' => $this->filteredDistricts,
            'filteredUpazilas' => $this->filteredUpazilas,
        ]);
    }



    



}
