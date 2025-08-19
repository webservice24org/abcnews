<?php

namespace App\Traits;


use App\Models\News\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

trait HandlesNewsDeletion
{
    protected function deletePermission()
    {
        $user = Auth::user();

        if (! $user->hasRole(['Super Admin', 'Admin'])) {
            abort(403, 'You are not authorized to delete news posts.');
        }
    }

    public function deleteConfirmed($id)
    {
        $this->deletePermission(); 

        $post = Post::find($id);

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
        

        $post = Post::withTrashed()->find($id);

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
        $this->deletePermission(); 

        $post = Post::withTrashed()->find($id);

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



