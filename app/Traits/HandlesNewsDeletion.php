<?php

namespace App\Traits;


use App\Models\NewsPost;
use Illuminate\Support\Facades\Storage;

trait HandlesNewsDeletion
{

    public function deleteConfirmed($id)
    {
        $post = NewsPost::find($id);

        if (!$post) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Post not found.'
            ]);
            return;
        }

        $post->delete();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Post deleted successfully.'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', $id);
    }


    public function restorePost($id)
    {
        $post = NewsPost::withTrashed()->find($id);

        if (!$post) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Post not found!'
            ]);
            return;
        }

        $post->restore();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Post restored successfully!'
        ]);

        $this->dispatch('newsRestored');
    }





    public function forceDeleteConfirmed($id)
    {
        $post = NewsPost::withTrashed()->find($id);

        if (!$post) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Post not found!',
            ]);
            return;
        }

        if ($post->news_thumbnail && Storage::disk('public')->exists($post->news_thumbnail)) {
            Storage::disk('public')->delete($post->news_thumbnail);
        }

        $post->forceDelete();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'News post permanently deleted!',
        ]);
    }


}


