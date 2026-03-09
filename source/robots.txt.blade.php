@php
    $baseUrl = rtrim((string) ($page->baseUrl ?? ''), '/');
    $sitemapUrl = $baseUrl !== '' ? $baseUrl . '/sitemap.xml' : '/sitemap.xml';
@endphp
User-agent: *
@if ($page->production)
Allow: /
@else
Disallow: /
@endif

Sitemap: {{ $sitemapUrl }}
