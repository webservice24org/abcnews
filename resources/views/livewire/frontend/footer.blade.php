<div class="rooter-wrapper">
    <div class="max-w-7xl mx-auto text-center mt-10">
            @php
            $globalBelowGridAd = \App\Models\Advertisement::where('ad_name', 'Global Before Footer')
                ->where('is_global', 1)
                ->where('status', 1)
                ->first();
        @endphp                            

        @if ($globalBelowGridAd)
            @if ($globalBelowGridAd->ad_image)
                <a href="{{ $globalBelowGridAd->ad_url ?? '#' }}" target="_blank">
                    <img src="{{ asset('storage/' . $globalBelowGridAd->ad_image) }}" alt="{{$globalBelowGridAd->ad_name}}" class="object-fill">
                </a>
            @elseif ($globalBelowGridAd->ad_code)
                {!! $globalBelowGridAd->ad_code !!}
            @endif

        @else
            {{-- Fallback image --}}
            <img src="{{ asset('storage/fallback-ad/home-section-below.png') }}" alt="Fallback Ad" class="object-fill">
        @endif
    </div>
    <footer class="mt-5 border-t border-white pt-10 pb-1 text-white" style="background-color: {{ $color->footer_bg ?? '#e7000b' }};">
        <div class="max-w-7xl mx-auto px-4 space-y-4">

            {{-- Top Row: Logo and Social Icons --}}
            <div class="flex flex-col md:flex-row justify-between items-center">
                {{-- Footer Logo --}}
                <div>
                    @if ($siteSetting?->footer_logo)
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/' . $siteSetting->footer_logo) }}" alt="Footer Logo" class="h-10">
                        </a>
                    @endif
                </div>

                {{-- Social Icons --}}
                <div class="mt-4 md:mt-0">
                    <livewire:frontend.social-icons />
                </div>
            </div>

            {{-- Footer Menu --}}
            <div class="mt-6">
                <ul class="flex flex-wrap gap-4 text-sm">
                    @foreach ($pages as $page)
                        <li>
                            <a href="{{ route('page.show', $page->slug) }}" 
                            class="hover:underline">
                                {{ $page->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


            {{-- Bottom Row: Copyright and Developer --}}
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-white border-t border-white pt-4">
                <div>
                    @if (!empty($siteInfo?->copyright_info))
                        <p>{!! $siteInfo->copyright_info !!}</p>
                    @endif
                </div>

                <div class="mt-2 md:mt-0">
                    <p>Developed by <a href="https://webservicebd.org/" class="underline hover:text-gray-200">WebserviceBD</a></p>
                </div>
            </div>

        </div>
    </footer>
</div>

