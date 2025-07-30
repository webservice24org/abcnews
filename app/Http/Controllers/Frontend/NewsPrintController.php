<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsPost;
use App\Models\SiteSetting;
use App\Models\SiteInfo;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
class NewsPrintController extends Controller
{


    public function downloadPdf($slug)
    {
        return view('layouts.news-print', [
            'news' => NewsPost::where('slug', $slug)->firstOrFail(),
            'siteSetting' => SiteSetting::first(),
            'siteInfo' => SiteInfo::first(),
        ]);
    }


}


