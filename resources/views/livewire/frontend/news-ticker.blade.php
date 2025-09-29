<div class="max-w-5xl mx-auto bg-[rgb(179,25,66)] text-white py-2">
    <div class="px-4 flex items-center gap-4">
        {{-- label --}}
        <span class="bg-white px-3 text-black py-1 text-sm font-bold uppercase rounded">
            লেটেস্ট নিউজ
        </span>

        {{-- ticker wrapper --}}
        <div id="{{ $uid }}-wrap" class="relative overflow-hidden flex-1" tabindex="0" aria-label="Breaking news ticker">
            @if($news->isEmpty())
                <div class="text-gray-400">লেটেস্ট নিউজ নাই</div>
            @else
                <div id="{{ $uid }}-track" class="ticker-track flex items-center">
                    {{-- original items --}}
                    @foreach($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}"
                        class="ticker-item inline-block mx-6 text-md text-white whitespace-nowrap">
                            {{ $item->news_title }}
                        </a>
                        <span class="text-white">|</span>
                    @endforeach

                    {{-- duplicate for seamless loop --}}
                    @foreach($news as $item)
                        <a href="{{ route('news.show', $item->slug) }}"
                        class="ticker-item inline-block mx-6 text-md text-white whitespace-nowrap">
                            {{ $item->news_title }}
                        </a>
                        <span class="text-white">|</span>
                    @endforeach

                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* minimal styling; all heavy work is JS-driven */
    #{{ $uid }}-wrap:focus { outline: none; }
    #{{ $uid }}-track { display: flex; align-items:center; white-space:nowrap; will-change: transform; }
    .ticker-item { font-weight:600; text-decoration:none; }
</style>
@endpush

@push('scripts')
<script>
(function(){
    // keep a registry so multiple tickers can exist
    window._newsTickerHandles = window._newsTickerHandles || {};

    function initTicker(uid) {
        const wrap = document.getElementById(uid + '-wrap');
        const track = document.getElementById(uid + '-track');
        if (!wrap || !track) return;

        // cleanup previous if exists
        if (window._newsTickerHandles[uid]) {
            const prev = window._newsTickerHandles[uid];
            if (prev.raf) cancelAnimationFrame(prev.raf);
            if (prev.onResize) window.removeEventListener('resize', prev.onResize);
            try { wrap.removeEventListener('mouseenter', prev.onMouseEnter); wrap.removeEventListener('mouseleave', prev.onMouseLeave); } catch(e){}
        }

        // state
        const state = {
            pos: 0,
            paused: false,
            raf: null,
            halfWidth: 0,
            lastTimestamp: performance.now(),
        };
        window._newsTickerHandles[uid] = state;

        // event handlers
        const onMouseEnter = () => state.paused = true;
        const onMouseLeave = () => state.paused = false;
        wrap.addEventListener('mouseenter', onMouseEnter);
        wrap.addEventListener('mouseleave', onMouseLeave);
        wrap.addEventListener('focusin', onMouseEnter);
        wrap.addEventListener('focusout', onMouseLeave);
        state.onMouseEnter = onMouseEnter;
        state.onMouseLeave = onMouseLeave;

        // compute half width (first copy)
        function computeWidths() {
            // ensure layout settled
            const children = Array.from(track.children);
            // if children < 2, nothing to scroll
            if (children.length === 0) {
                state.halfWidth = 0;
                return;
            }
            // first half length = sum of widths of first N/2 children
            const half = Math.floor(children.length / 2);
            let w = 0;
            for (let i = 0; i < half; i++) {
                w += children[i].offsetWidth;
            }
            state.halfWidth = Math.round(w);
            // reset pos if too negative
            state.pos = state.pos % state.halfWidth;
        }

        // set sensible speed (px per second). You can tweak this.
        function computeSpeed() {
            const base = Math.max(12000, state.halfWidth * 20); // higher = slower
            return Math.max(20, state.halfWidth / (base / 1000));
        }


        // animation loop
        computeWidths();
        let speed = computeSpeed();
        let last = performance.now();

        function step(now) {
            const delta = (now - last) / 1000;
            last = now;

            if (!state.paused && state.halfWidth > 0) {
                state.pos -= speed * delta;
                if (state.pos <= -state.halfWidth) {
                    // wrapped one half, normalize
                    state.pos += state.halfWidth;
                }
                track.style.transform = 'translateX(' + state.pos + 'px)';
            }
            state.raf = requestAnimationFrame(step);
        }

        // start
        state.raf = requestAnimationFrame(step);

        // recompute widths on resize (debounced)
        let resizeTimer = null;
        function onResize() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function(){
                computeWidths();
                speed = computeSpeed();
            }, 150);
        }
        window.addEventListener('resize', onResize);
        state.onResize = onResize;
    }

    // init all tickers on DOM ready
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('[id$="-wrap"]').forEach(el => {
            // only init those that follow our naming convention: news-ticker-...
            if (el.id && el.id.indexOf('news-ticker-') === 0) {
                initTicker(el.id.replace('-wrap',''));
            }
        });
    });

    // re-init after Livewire updates (so dynamic content works)
    if (window.Livewire) {
        window.Livewire.hook('message.processed', (message, component) => {
            // re-init any tickers inside the updated component
            // we look for wraps inside the component DOM node
            try {
                const dom = component.el || document;
                const tickers = dom.querySelectorAll('[id$="-wrap"]');
                tickers.forEach(el => {
                    if (el.id && el.id.indexOf('news-ticker-') === 0) {
                        initTicker(el.id.replace('-wrap',''));
                    }
                });
            } catch (e) {
                // ignore
            }
        });
    }
})();
</script>
@endpush
