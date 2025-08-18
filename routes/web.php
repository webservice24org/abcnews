<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

//use App\Livewire\Admin\Dashboard;
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
use \App\Livewire\Admin\MenuManager;
use \App\Livewire\Admin\SiteSettingForm;
use \App\Livewire\Admin\SiteInfoForm;
use \App\Livewire\Admin\SiteConnectionForm;
use \App\Livewire\Admin\SocialConnectionForm;
use \App\Livewire\Admin\AdvertisementForm;
use \App\Livewire\Admin\AdList;
use App\Livewire\Admin\VideoPostForm;
use App\Livewire\Admin\VideoPostList;
use App\Livewire\Admin\PhotoNewsForm;
use App\Livewire\Admin\PhotoNewsList;
use App\Livewire\Admin\ClearCache;
use App\Livewire\Admin\CustomCodeEditor;
use App\Livewire\Admin\ThemeColorPicker;
use App\Livewire\Admin\ContactList;
use App\Livewire\Admin\ContactReply;
use App\Livewire\Admin\SubscriberList;
use App\Livewire\Admin\NewsletterSender;
use App\Livewire\Admin\Pages\PageList;
use App\Livewire\Admin\Pages\PageEdit;

use App\Http\Controllers\Frontend\NewsPrintController; 



use App\Livewire\Frontend\HomePage;
use App\Livewire\Frontend\NewsShow;
 use App\Livewire\Frontend\CategoryNewsSection;
 use App\Livewire\Frontend\SubCategoryNewsSection;
 use App\Livewire\Frontend\DivisionNewsSection;
 use App\Livewire\Frontend\DistrictNewsSection;
 use App\Livewire\Frontend\UpazilaNewsSection;

 use App\Livewire\Frontend\NewsArchivePage;
 use App\Livewire\Frontend\SearchResults;
 use App\Livewire\Frontend\SingleVideo;
 use App\Livewire\Frontend\AllVideos;
 use App\Livewire\Frontend\SinglePhotoNews;
 use App\Livewire\Frontend\AllPhotoNews;
 use App\Livewire\Frontend\UserNews;
 use App\Livewire\Frontend\SubscriberForm;
 
use App\Livewire\Frontend\PageShow;

use Illuminate\Support\Facades\URL;
use App\Models\User;

Route::get('/', HomePage::class)->name('home');
//Route::get('/news/{slug}', NewsShow::class)->name('news.show');


/*
Route::get('/', function () {
    return view('welcome');
})->name('home');
*/

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

    Route::get('/admin/menu-manager', MenuManager::class)->name('admin.menu-manager');

    Route::get('/admin/site-settings', SiteSettingForm::class)->name('admin.site-settings');
    Route::get('/admin/site-info', SiteInfoForm::class)->name('admin.site-info');
    Route::get('/admin/site-connections', SiteConnectionForm::class)->name('admin.site-connections');

    Route::get('/admin/social-connections', SocialConnectionForm::class)->name('admin.social-connections');

    Route::get('/admin/advertisements/create', AdvertisementForm::class)->name('admin.advertisements.create');
    Route::get('/admin/ads', AdList::class)->name('admin.ads-list');
    Route::get('admin/advertisements/edit/{id}', AdvertisementForm::class)->name('ads.edit');
    Route::get('/admin/video/create', VideoPostForm::class)->name('admin.video.create');



    Route::get('/admin/video/list', VideoPostList::class)->name('admin.video.list');
    Route::get('/admin/video/create', VideoPostForm::class)->name('admin.video.create');
    Route::get('/admin/video/edit/{id}', VideoPostForm::class)->name('admin.video.edit');

    Route::get('/admin/photo-news/create', PhotoNewsForm::class)->name('admin.photo-news.create');
    Route::get('/admin/photo-news', PhotoNewsList::class)->name('admin.photo-news.index');
    Route::get('admin/photo-news/edit/{id}', PhotoNewsForm::class)->name('admin.photo-news.edit');

    Route::get('/admin/clear-cache', ClearCache::class)
    ->name('admin.clear.cache');
    Route::get('/custom-code', CustomCodeEditor::class)->name('admin.custom-code');
   Route::get('/admin/theme-color-picker', ThemeColorPicker::class)->name('theme.color.picker');

   Route::get('/admin/pages', PageList::class)->name('pages.index');
   
    Route::get('/admin/pages/edit/{id}', PageEdit::class)->name('pages.edit');
    //Route::get('/admin/pages/create', \App\Livewire\Admin\Pages\PageEdit::class)->name('pages.create');

    Route::get('/admin/contacts', ContactList::class)->name('contacts.index');
    Route::get('/contacts/{contact}/reply', ContactReply::class)->name('contacts.reply');
    Route::get('/admin/subscribers', SubscriberList::class)->name('admin.subscribers');

    Route::get('/admin/newsletter', NewsletterSender::class)->name('admin.newsletter');
    
});





Route::get('/subscriber/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    // Validate hash
    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403, 'Invalid or expired verification link.');
    }

    // Mark verified if not already
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect()->route('login')->with('status', 'Your email has been verified successfully!');
})->middleware('signed')->name('subscriber.verification.verify');



//Route::get('/unsubscribe/{email}', SubscriberForm::class . '@unsubscribe')->name('unsubscribe');

    Route::get('/unsubscribe/{email}', \App\Livewire\Frontend\UnsubscribePage::class)
    ->name('unsubscribe');


Route::get('news/{slug}', NewsShow::class)->where('slug', '^(?!categories$).+')->name('news.show');



Route::get('/category/{slug}', CategoryNewsSection::class)->name('category.show');
Route::get('/subcategory/{subcategory:slug}', SubCategoryNewsSection::class)->name('subcategory.show');



Route::get('/division/{slug}', DivisionNewsSection::class)->name('division.show');
Route::get('/district/{slug}', DistrictNewsSection::class)->name('district.show');
Route::get('/upazila/{slug}', UpazilaNewsSection::class)->name('upazila.show');


Route::get('/archive/{date}', NewsArchivePage::class)->name('archive.show');



Route::get('/print-news/{slug}/print', [NewsPrintController::class, 'downloadPdf'])->name('news.print');



Route::get('/search', SearchResults::class)->name('search');

Route::get('/video/{id}', SingleVideo::class)->name('video.show');
Route::get('/videos', AllVideos::class)->name('videos.all');
Route::get('/photo-news/{id}', SinglePhotoNews::class)->name('photo-news.show');



Route::get('/photo-news', AllPhotoNews::class)->name('photo-news.index');

Route::get('/all-news/user/{user}', UserNews::class)->name('news.user');

Route::get('/page/{slug}', PageShow::class)->name('page.show');


require __DIR__.'/auth.php';
