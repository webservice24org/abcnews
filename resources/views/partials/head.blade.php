<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ ($siteInfo->site_name ?? $title ?? config('app.name')) }} | @if (!empty($siteInfo->tagline))
    {{ $siteInfo->tagline }}
    @endif
</title>

@if (!empty($siteSetting) && $siteSetting->favicon)
    <link rel="icon" href="{{ asset('storage/' . $siteSetting->favicon) }}" type="image/x-icon" />
@else
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
@endif

<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
