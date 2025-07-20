<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Users\PermissionManager;
use App\Livewire\Users\RolePermissionManager;
use App\Livewire\Users\UserList;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\SubCategoryManager;
use \App\Livewire\Admin\DivisionManager;
use \App\Livewire\Admin\DistrictManager;
use \App\Livewire\Admin\UpazilaManager;
use App\Livewire\Admin\TagManager;
use App\Livewire\Admin\NewsPostForm;
use App\Livewire\Admin\AllNewsList;
use App\Livewire\Admin\DraftNewsList;
use App\Livewire\Admin\ScheduledNewsList;
use \App\Livewire\Admin\TrashedNewsList;




Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
    Route::get('users/all-users', UserList::class)->name('users.index');
    Route::view('users/roles', 'roles.index')->name('roles.index');
    Route::get('users/permissions', PermissionManager::class)->name('permissions.index');

    
    Route::get('news/categories', CategoryManager::class)->name('categories.index');
    Route::get('/admin/sub-categories', SubCategoryManager::class)->name('sub-categories.index');
    Route::get('/admin/divisions', DivisionManager::class)->name('divisions.index');
    Route::get('/admin/districts', DistrictManager::class)->name('districts.index');
    Route::get('admin/upazilas', UpazilaManager::class)->name('upazilas.index');
    

    Route::get('admin/tags', TagManager::class)->name('tags.index');

    
    Route::get('admin/news/create', NewsPostForm::class)->name('posts.create');
    Route::get('admin/news/edit/{id}', NewsPostForm::class)->name('posts.edit');
    Route::get('admin/news', AllNewsList::class)->name('news.index');
   Route::get('admin/news/drafts', DraftNewsList::class)->name('news.drafts');
   Route::get('admin/news/scheduled', ScheduledNewsList::class)->name('news.scheduled');

   Route::get('admin/news/trashed', TrashedNewsList::class)->name('posts.trashed');



    

    
});





require __DIR__.'/auth.php';
