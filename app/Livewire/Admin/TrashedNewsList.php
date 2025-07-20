<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use App\Models\NewsPost;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use App\Traits\HandlesNewsDeletion;

class TrashedNewsList extends Component
{
    use WithPagination, HandlesNewsDeletion;

    protected $listeners = [
    'deleteConfirmed' => 'deleteConfirmed',
    'restoreConfirmed' => 'restoreConfirmed',

    ];



    protected $paginationTheme = 'tailwind';


    

   

   

    

    public function render()
    {
        $trashedNews = NewsPost::onlyTrashed()->latest()->paginate(10);

        return view('livewire.admin.trashed-news-list', compact('trashedNews'));
    }
}
