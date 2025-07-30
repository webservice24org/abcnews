<footer class="mt-10 border-t border-white pt-10 pb-10 bg-red-600 text-white">
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

