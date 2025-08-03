
<div class="border-b border-zinc-200 dark:border-zinc-700 pb-2 text-center">
   <div class="text-center">
        @if (!empty($siteSetting) && $siteSetting->header_logo)
            <img src="{{ asset('storage/' . $siteSetting->header_logo) }}"
                alt="Logo"
                class="inline-block mx-auto h-10 md:h-10 object-contain">
        @else
            <img src="{{ asset('storage/logos/front-real-logo.png') }}"
                alt="Logo"
                class="inline-block mx-auto h-10 md:h-10 object-contain">
        @endif
    </div>

</div>
