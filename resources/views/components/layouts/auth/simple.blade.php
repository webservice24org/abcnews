<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <div class="text-center">
                        @if (!empty($siteSetting) && $siteSetting->header_logo)
                            <img src="{{ asset('storage/' . $siteSetting->header_logo) }}"
                                alt="Logo"
                                class="inline-block mx-auto h-10 md:h-16 object-contain">
                        @else
                            <img src="{{ asset('storage/logos/front-real-logo.png') }}"
                                alt="Logo"
                                class="inline-block mx-auto h-10 md:h-16 object-contain">
                        @endif
                    </div>

                    <span class="sr-only">{{ config('app.name', 'MicroWeb Technology') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
        
    </body>
</html>
