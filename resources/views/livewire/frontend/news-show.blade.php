<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-indigo-900 mb-4">{{ $news->news_title }}</h1>
    <div class="text-sm text-gray-600 mb-4">
        By {{ $news->user->name ?? 'Unknown' }} • {{ $news->created_at->format('F d, Y') }}
    </div>
    <div class="prose max-w-none">
        {!! $news->news_description !!}
    </div>
</div>
