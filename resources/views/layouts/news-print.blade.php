<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .wrapper-print { width: 1200px;margin: 0 auto;}
        .header {display: flex;justify-content: space-between;align-items: center;margin-bottom: 30px;padding: 5px;color: #000;font-weight: bold;}
        .logo { height: 60px; }
        .title {font-size: 30px;font-weight: bold;margin-top: 10px;}
        .content img { max-width: 100%; height: auto; margin-bottom: 15px; }
        .footer {font-size: 12px;text-align: center;width: 100%;margin-top: 26px;} 
    </style>
</head>
<body>
    <div class="wrapper-print">
        <div class="no-print">
            <button onclick="window.print()">🖨️ Print This Page</button>
        </div>
        <div class="header">
            <div>
                <small>Print Date: {{ now()->format('d M Y, h:i A') }}</small>
            </div>
            @if (!empty($siteSetting) && $siteSetting->print_logo)
                <div style="text-align: center;">
                    <img src="{{ asset('storage/' . $siteSetting->print_logo) }}" class="logo" alt="Logo">
                </div>
            @endif
            <div style="text-align: right;">
                <div><strong>{{ $siteInfo->site_name ?? config('app.name') }}</strong></div>
                <small>{{ $siteInfo->tagline ?? '' }}</small>
            </div>
        </div>        

        <div class="content">
            <h2 class="title">{{ $news->news_title }}</h2>
            <p style="font-size: 14px; margin-bottom: 10px;">
                প্রকাশ: {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at) }}
            </p>

            @if ($news->news_thumbnail)
                <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}">
            @endif

            <div>{!! $news->news_description !!}</div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ $siteInfo->site_name ?? config('app.name') }}. All rights reserved.
        </div>
    </div>

</body>
</html>
