<div class="rooter-wrapper max-w-5xl mx-auto">
    <div class="text-center">
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

        
        @endif
    </div>
    <footer class="max-w-5xl mx-auto border-t border-white pt-10 pb-1 text-white" style="background-color: {{ $color->footer_bg ?? '#e7000b' }};">
        <div class=" px-4 space-y-4">

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

                {{-- Footer Menu --}}
                <div>
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

               
            </div>
             
            <div class="flex flex-col md:flex-row justify-between items-center border-t border-white pt-4">
                {{-- Footer Logo --}}
                <div>
                    @if (!empty($siteInfo?->office_address))
                        <p>অফিসঃ {{$siteInfo->office_address}}</p>
                    @endif
                </div>

                {{-- Footer Menu --}}
                <div>
                    @if (!empty($siteInfo?->office_address))
                        <p>সম্পাদক ও প্রকাশকঃ {{$siteInfo->editor}}</p>
                    @endif
                </div>

                {{-- Social Icons --}}
                <div class="mt-4 md:mt-0">
                    @if(!empty($siteInfo->email))
                    <h4 class="border-b border-amber-100 text-center font-bold">যোগাযোগ</h4>

                    
                        <p class="flex items-center gap-2 mt-2">
                            <i class="fa-solid fa-envelope text-white"></i>
                            <span>{{ $siteInfo->email }}</span>
                        </p>
                    @endif

                    @if(!empty($siteInfo->mobile))
                        <p class="flex items-center gap-2 mt-2">
                            <i class="fa-solid fa-phone text-white"></i>
                            <span>{{ $siteInfo->mobile }}</span>
                        </p>
                    @endif
                </div>

            </div>

            {{-- Social Icons --}}
                <div class="mt-4 md:mt-0">
                    <livewire:frontend.social-icons />
                </div>

            

            {{-- Bottom Row: Copyright and Developer --}}
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-white  pt-4">
                <div>
                    @if (!empty($siteInfo?->copyright_info))
                        <p>{!! $siteInfo->copyright_info !!}</p>
                    @endif
                </div>

                <div class="mt-2 md:mt-0">
                    <p class="hidden">Developed by <a href="https://webservicebd.org/" class="underline hover:text-gray-200">WebserviceBD</a></p>
                </div>
            </div>

        </div>
    </footer>
</div>

