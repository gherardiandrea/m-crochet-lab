<!DOCTYPE html>
<html lang="it" class="scroll-smooth">
    <head>
        @php
            $siteName = (string) $page->siteName;
            $tagline = (string) $page->tagline;
            $pageTitle = (string) $page->get('title', '');
            $productName = method_exists($page, 'get') ? (string) $page->get('nome', '') : '';

            // Il brand resta sempre nel <title>: "Prodotto | Brand", "Pagina | Brand", in home "Brand | slogan".
            if ($productName !== '') {
                $seoTitle = $productName . ' | ' . $siteName;
            } elseif ($pageTitle !== '') {
                $seoTitle = $pageTitle . ' | ' . $siteName;
            } else {
                $seoTitle = $siteName . ' | ' . $tagline;
            }

            $rawDescription = method_exists($page, 'get')
                ? (string) $page->get('seoDescription', $page->get('description', ''))
                : (string) ($page->description ?? '');

            if ($rawDescription === '' && method_exists($page, 'getContent')) {
                $rawDescription = trim(strip_tags((string) $page->getContent()));
            }

            if ($rawDescription === '' && $productName !== '') {
                $rawDescription = 'Scopri ' . $productName . ', borsa crochet artigianale realizzata a mano da ' . $siteName . '.';
            }

            if ($rawDescription === '') {
                $rawDescription = $tagline;
            }

            $seoDescription = trim(preg_replace('/\s+/', ' ', $rawDescription));
            if (function_exists('mb_substr') && function_exists('mb_strlen') && mb_strlen($seoDescription) > 160) {
                $seoDescription = rtrim(mb_substr($seoDescription, 0, 157)) . '...';
            }

            $seoImagePath = method_exists($page, 'get')
                ? (string) $page->get('seoImage', $page->get('copertina', '/assets/images/homepage/homepage.jpg'))
                : '/assets/images/homepage/homepage.jpg';

            $baseUrl = rtrim((string) ($page->baseUrl ?? ''), '/');
            $pagePath = (string) ($page->getPath() ?? '/');
            $canonicalPath = $pagePath === '/' ? '' : $pagePath;
            $canonicalUrl = $baseUrl !== '' ? $baseUrl . $canonicalPath : '';
            $seoImage = $baseUrl !== '' ? $baseUrl . $seoImagePath : $seoImagePath;
            $ogType = $productName !== '' ? 'product' : 'website';
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $seoTitle }}</title>
        <meta name="description" content="{{ $seoDescription }}">
        <meta name="robots" content="index, follow">

        @if ($canonicalUrl !== '')
            <link rel="canonical" href="{{ $canonicalUrl }}">
        @endif

        <meta property="og:locale" content="it_IT">
        <meta property="og:type" content="{{ $ogType }}">
        <meta property="og:site_name" content="{{ $siteName }}">
        <meta property="og:title" content="{{ $seoTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:image" content="{{ $seoImage }}">
        @if ($canonicalUrl !== '')
            <meta property="og:url" content="{{ $canonicalUrl }}">
        @endif

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image" content="{{ $seoImage }}">

        <link rel="icon" href="/favicon.png" type="image/png">
        <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/icon-192.png">
        <link rel="icon" type="image/png" sizes="512x512" href="/assets/images/icon-512.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="theme-color" content="#7f5539">

        <link rel="preload" href="/assets/fonts/fraunces-latin.woff2" as="font" type="font/woff2" crossorigin>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="M Crochet">

        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'description' => 'Borse all\'uncinetto fatte a mano con passione e cura artigianale.',
            'url' => $baseUrl !== '' ? $baseUrl : 'https://m-crochet-lab.netlify.app',
            'logo' => ($baseUrl !== '' ? $baseUrl : 'https://m-crochet-lab.netlify.app') . '/assets/images/logo.webp',
            'sameAs' => [
                'https://www.instagram.com/m_crochet_lab/',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>

        @if ($productName !== '')
            @php
                $productPriceRaw = method_exists($page, 'get') ? (string) $page->get('prezzo', '') : '';
                $productPrice = preg_replace('/[^\d,\.]/', '', $productPriceRaw);
                $productPrice = str_replace(',', '.', $productPrice);
                $productGallery = method_exists($page, 'get') ? (array) $page->get('gallery', []) : [];
                $absoluteBase = $baseUrl !== '' ? $baseUrl : 'https://m-crochet-lab.netlify.app';
                $productImages = array_values(array_map(function ($img) use ($absoluteBase) {
                    return $absoluteBase . $img;
                }, $productGallery));
                if (empty($productImages)) {
                    $productImages = [$absoluteBase . $seoImagePath];
                }
                $productSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'Product',
                    'name' => $productName,
                    'description' => $seoDescription,
                    'image' => $productImages,
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => $siteName,
                    ],
                ];
                if ($productPrice !== '') {
                    $productSchema['offers'] = [
                        '@type' => 'Offer',
                        'price' => $productPrice,
                        'priceCurrency' => 'EUR',
                        'availability' => 'https://schema.org/InStock',
                        'url' => $canonicalUrl !== '' ? $canonicalUrl : ($absoluteBase . $pagePath),
                        'itemCondition' => 'https://schema.org/NewCondition',
                    ];
                }
            @endphp
            <script type="application/ld+json">
            {!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>

            @php
                $breadcrumbSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => $absoluteBase . '/',
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Modelli',
                            'item' => $absoluteBase . '/#modelli',
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => $productName,
                            'item' => $canonicalUrl !== '' ? $canonicalUrl : ($absoluteBase . $pagePath),
                        ],
                    ],
                ];
            @endphp
            <script type="application/ld+json">
            {!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>
        @endif

        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <style>[x-cloak]{display:none!important}</style>
        <script>
            function loadGA() {
                var s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=G-4T9M96K0MF';
                document.head.appendChild(s);
                window.dataLayer = window.dataLayer || [];
                window.gtag = function(){ dataLayer.push(arguments); };
                gtag('js', new Date());
                gtag('config', 'G-4T9M96K0MF');
            }
            if (localStorage.getItem('cookie_consent') === 'accepted') { loadGA(); }
        </script>
        {{-- Versione fissa con hash di integrità: un aggiornamento automatico del CDN potrebbe rompere gallery e banner cookie --}}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.17.4/dist/cdn.min.js" integrity="sha384-5/joNqFnRyVWzXp99bHot6RHG+EksGp+USSgZwPar7T9SD9PKKER37n/8bXBAZGd" crossorigin="anonymous"></script>
    </head>
    <body class="bg-stone-50 text-stone-800 font-sans antialiased flex flex-col min-h-screen">

        @php
            $promoScadenza = (string) $page->get('promoScadenza', '');
            $promoVisibile = $page->promoAttiva && ($promoScadenza === '' || date('Y-m-d') <= $promoScadenza);
        @endphp
        @if ($promoVisibile)
        <div id="promo-bar" style="background:#7f5539;color:#e6ccb2;text-align:center;padding:10px 40px;font-size:0.82rem;font-weight:500;line-height:1.4;position:relative;">
            {!! $page->promoBarra !!}
            <a href="https://ig.me/m/m_crochet_lab" target="_blank" rel="noopener noreferrer" style="color:#fff;text-decoration:underline;margin-left:8px;white-space:nowrap;">Scrivimi su Instagram →</a>
        </div>
        @if ($promoScadenza !== '')
            {{-- Il sito è statico: senza questo controllo la barra resterebbe online fino al deploy successivo --}}
            <script>if (new Date() > new Date('{{ $promoScadenza }}T23:59:59')) document.getElementById('promo-bar').remove();</script>
        @endif
        @endif

        <header class="bg-[#e6ccb2] py-10 text-center shadow-sm px-4">
            <p class="text-4xl md:text-5xl font-serif text-[#7f5539] mb-2 font-bold"><a href="/">{{ $siteName }}</a></p>
            <p class="text-[#9c6644] text-lg">{{ $tagline }}</p>
        </header>

        <nav class="sticky top-0 z-20 bg-stone-50/95 backdrop-blur border-b border-stone-200" aria-label="Navigazione principale">
            <div class="container mx-auto px-4 max-w-6xl">
                <div class="flex gap-2 sm:gap-3 overflow-x-auto py-3 text-sm sm:text-base whitespace-nowrap">
                    <a href="/#home-section" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Home</a>
                    <a href="/#modelli" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Modelli</a>
                    @if(count(json_decode(json_encode($page->get('prontaConsegna', [])), true) ?? []) > 0)
                    <a href="/#pronte-per-te" class="px-4 py-2 rounded-full font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition">Pronte per te</a>
                    @endif
                    <a href="/#chi-sono" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Chi sono</a>
                    <a href="/#spedizioni" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Spedizioni</a>
                    <a href="/#contatti" class="px-4 py-2 rounded-full font-semibold text-[#7f5539] hover:bg-[#e6ccb2] transition">Contatti</a>
                </div>
            </div>
        </nav>

        <main class="container mx-auto px-4 py-12 max-w-6xl flex-grow">
            @yield('body')
        </main>

        <div
            x-data="{
                show: false,
                init() {
                    if (!localStorage.getItem('cookie_consent')) this.show = true;
                },
                accept() {
                    localStorage.setItem('cookie_consent', 'accepted');
                    if (typeof loadGA === 'function' && !window.__gaLoaded) { loadGA(); window.__gaLoaded = true; }
                    this.show = false;
                },
                decline() {
                    localStorage.setItem('cookie_consent', 'declined');
                    this.show = false;
                },
                reopen() {
                    localStorage.removeItem('cookie_consent');
                    this.show = true;
                }
            }"
            @reopen-cookie-banner.window="reopen()"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            role="dialog"
            aria-label="Consenso cookie"
            style="position:fixed;bottom:0;left:0;right:0;z-index:50;background:#fff;border-top:2px solid #e6ccb2;box-shadow:0 -4px 24px rgba(127,85,57,0.10);"
        >
            <div style="max-width:900px;margin:0 auto;padding:16px 20px;display:flex;flex-wrap:wrap;align-items:center;gap:16px;">

                <div style="display:flex;align-items:flex-start;gap:12px;flex:1;min-width:260px;">
                    <span style="font-size:1.4rem;line-height:1;margin-top:2px;" aria-hidden="true">🍪</span>
                    <div>
                        <p style="margin:0 0 3px;font-size:0.875rem;font-weight:600;color:#1c1917;">Questo sito usa i cookie</p>
                        <p style="margin:0;font-size:0.75rem;color:#78716c;line-height:1.5;">
                            Usiamo cookie analitici (Google Analytics) per capire come viene visitato il sito.
                            Nessun dato personale identificativo viene raccolto.
                            <a href="/cookie" style="color:#7f5539;text-decoration:underline;">Cookie Policy</a>
                            &middot;
                            <a href="/privacy" style="color:#7f5539;text-decoration:underline;">Privacy Policy</a>
                        </p>
                    </div>
                </div>

                <div style="display:flex;gap:10px;flex-shrink:0;">
                    <button
                        @click="decline()"
                        style="padding:9px 22px;border-radius:999px;font-size:0.875rem;font-weight:600;color:#57534e;background:transparent;border:1.5px solid #d6d3d1;cursor:pointer;transition:border-color .2s,color .2s;"
                        onmouseover="this.style.borderColor='#a8a29e';this.style.color='#292524'"
                        onmouseout="this.style.borderColor='#d6d3d1';this.style.color='#57534e'"
                    >Rifiuta</button>
                    <button
                        @click="accept()"
                        style="padding:9px 22px;border-radius:999px;font-size:0.875rem;font-weight:600;color:#fff;background:#7f5539;border:1.5px solid #7f5539;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='#9c6644'"
                        onmouseout="this.style.background='#7f5539'"
                    >Accetta</button>
                </div>

            </div>
        </div>

        <footer class="bg-[#7f5539] text-[#e6ccb2] text-center py-10 px-4 mt-auto">
            <div class="mb-5">
                <img src="/assets/images/logo.webp" srcset="{{ $page->srcset('/assets/images/logo.webp', 400) }}" sizes="72px" alt="{{ $siteName }}" loading="lazy" decoding="async" width="72" height="72" style="display:block;margin:0 auto;width:72px;height:72px;border-radius:50%;object-fit:cover;opacity:0.92;">
            </div>
            <div class="mb-6">
                <a href="https://www.instagram.com/m_crochet_lab/" 
                target="_blank" 
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 hover:text-white transition-colors duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-instagram transform group-hover:scale-110 transition-transform" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.269.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.003 1.44c2.147 0 2.4.008 3.248.047.78.036 1.203.166 1.485.276.374.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.847.047 1.097.047 3.247s-.008 2.399-.047 3.248c-.036.78-.166 1.203-.276 1.485-.145.374-.319.64-.599.92-.28.28-.546.453-.92.598-.281.11-.705.24-1.485.276-.847.039-1.097.047-3.247.047s-2.399-.008-3.248-.047c-.78-.036-1.203-.166-1.485-.276a2.47 2.47 0 0 1-.92-.598 2.47 2.47 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.847-.046-1.097-.046-3.247s.008-2.399.046-3.248c.035-.78.166-1.203.276-1.485.145-.374.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                    </svg>
                    <span class="font-medium">Seguimi su Instagram</span>
                </a>
            </div>

            <div class="mb-5 text-sm flex flex-wrap items-center justify-center gap-4">
                <a href="/privacy" class="hover:text-white transition-colors">Privacy Policy</a>
                <span aria-hidden="true" class="opacity-50">·</span>
                <a href="/cookie" class="hover:text-white transition-colors">Cookie Policy</a>
                <span aria-hidden="true" class="opacity-50">·</span>
                <a href="/termini-vendita" class="hover:text-white transition-colors">Termini di Vendita</a>
                <span aria-hidden="true" class="opacity-50">·</span>
                <a href="/spedizioni" class="hover:text-white transition-colors">Spedizioni</a>
                <span aria-hidden="true" class="opacity-50">·</span>
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('reopen-cookie-banner'))"
                    class="hover:text-white transition-colors hover:underline cursor-pointer"
                    style="font: inherit; color: inherit; background: transparent; border: 0; padding: 0; margin: 0;"
                >Gestisci preferenze cookie</button>
            </div>
            <p class="text-xs opacity-70 mb-3">M Crochet Lab di Mara Benintendi &mdash; Paladina (BG) &mdash; Attività artigianale occasionale non professionale</p>

            <p class="text-sm opacity-80">&copy; {{ date('Y') }} {{ $siteName }}. Fatte a mano con il ❤️.</p>
            <p class="text-xs opacity-50 mt-2">Sito sviluppato da <a href="https://andrea-gherardi.netlify.app/" target="_blank" rel="noopener noreferrer" class="underline hover:opacity-80">Andrea Gherardi</a> &middot; <a href="https://github.com/gherardiandrea" target="_blank" rel="noopener noreferrer" class="underline hover:opacity-80">GitHub</a></p>
        </footer>
    </body>
</html>