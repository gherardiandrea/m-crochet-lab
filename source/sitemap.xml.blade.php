@php
    $baseUrl = rtrim((string) ($page->baseUrl ?? ''), '/');

    $staticPaths = [
        '/',
        '/privacy',
        '/cookie',
        '/spedizioni',
    ];

    $productPaths = collect($borse ?? [])
        ->map(function ($borsa) {
            return (string) $borsa->getPath();
        })
        ->filter()
        ->all();

    $paths = collect(array_merge($staticPaths, $productPaths))
        ->unique()
        ->values();
@endphp
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($paths as $path)
    @php
        $normalizedPath = (string) $path === '/' ? '' : '/' . ltrim((string) $path, '/');
        $loc = $baseUrl !== '' ? $baseUrl . $normalizedPath : ($normalizedPath !== '' ? $normalizedPath : '/');
    @endphp
    <url>
        <loc>{{ $loc }}</loc>
    </url>
@endforeach
</urlset>
