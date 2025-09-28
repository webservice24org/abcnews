<div class="flex gap-4 text-gray-600 text-xl">

    @if ($social?->facebook)
        <a href="{{ $social->facebook }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
            <i class="fa-brands fa-square-facebook"></i>
        </a>
    @endif

    @if ($social?->twitter)
        <a href="{{ $social->twitter }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
            <i class="fa-brands fa-square-x-twitter"></i>
        </a>
    @endif

    @if ($social?->pinterest)
        <a href="{{ $social->pinterest }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
            <i class="fa-brands fa-linkedin"></i>
        </a>
    @endif

    @if ($social?->tiktok)
        <a href="{{ $social->tiktok }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
            <i class="fa-brands fa-tiktok"></i>
        </a>
    @endif

    @if ($social?->instagram)
        <a href="{{ $social->instagram }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
            <i class="fa-brands fa-square-instagram"></i>
        </a>
    @endif

    @if ($social?->youtube)
        <a href="{{ $social->youtube }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
           <i class="fa-brands fa-square-youtube"></i>
        </a>
    @endif 
    @if ($social?->whatsapp)
        <a href="{{ $social->whatsapp }}" target="_blank" class="hover:text-red-600 hover:bg-white bg-white p-1 rounded">
           <i class="fa-brands fa-square-whatsapp"></i>
        </a>
    @endif

</div>