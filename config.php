<?php

return [
    'production' => false,
    'baseUrl' => '',
    // Brand e slogan dell'header: le pagine usano title/description nel frontmatter per i propri testi
    'siteName' => 'M Crochet Lab',
    'tagline' => 'Borse all\'uncinetto fatte a mano con passione',
    'shipping' => [
        'preparationTime' => '5-8 giorni lavorativi',
        'deliveryTime' => '24-72 ore dopo la spedizione',
        'tracking' => 'Il codice di tracciamento te lo invio appena parte il pacco.',
        'customOrders' => 'Tempi comunicati prima della conferma',
        'costs' => 'Il prezzo dipende dal formato del pacco: il costo esatto te lo confermo prima dell\'ordine.',
        // Tariffe InPost per formato del pacco: la home mostra la più bassa ("da ...")
        'inpost' => [
            'Small' => '4,99€',
            'Medium' => '5,99€',
            'Large' => '6,99€',
        ],
    ],
    'email' => 'marabenintendi00@gmail.com',
    'prontaConsegna' => [
        [
            'nome' => 'MBag Medium',
            'prezzo' => '30€',
            'gallery' => [
                '/assets/images/disponibili-ora/1/1_1.webp',
                '/assets/images/disponibili-ora/1/1_2.webp',
            ],
        ],
        [
            'nome' => 'SBag',
            'prezzo' => '30€',
            'gallery' => [
                '/assets/images/disponibili-ora/2/2_2.webp',
                '/assets/images/disponibili-ora/2/2_1.webp',
            ],
        ],
        [
            'nome' => 'MBag Large',
            'prezzo' => '35€',
            'gallery' => [
                '/assets/images/disponibili-ora/3/3_1.webp',
                '/assets/images/disponibili-ora/3/3_2.webp',
                '/assets/images/disponibili-ora/3/3_3.webp',
            ],
        ],
        [
            'nome' => 'MBag Tytan',
            'prezzo' => '35€',
            'novita' => true,
            'gallery' => [
                '/assets/images/disponibili-ora/4/4_1.webp',
                '/assets/images/disponibili-ora/4/4_2.webp',
            ],
        ],
        [
            'nome' => 'MBag Extra Large',
            'prezzo' => '40€',
            'gallery' => [
                '/assets/images/disponibili-ora/5/5_1.webp',
                '/assets/images/disponibili-ora/5/5_2.webp',
                '/assets/images/disponibili-ora/5/5_3.webp',
            ],
        ],
        [
            'nome' => 'MBag Medium',
            'prezzo' => '30€',
            'gallery' => [
                '/assets/images/disponibili-ora/6/6_1.webp',
                '/assets/images/disponibili-ora/6/6_2.webp',
            ],
        ],
    ],

    'promoAttiva' => false,
    'promoScadenza' => '2026-05-19',
    'promoBarra' => '🎁 Offerta di lancio: spedizione gratuita + un regalo misterioso per ogni ordine!',

    // Borse con "famiglia" nel frontmatter: descrizione del blocco nel catalogo e colori già
    // realizzati mostrati nelle schede (le borse senza famiglia usano "colori" nel frontmatter)
    'famiglie' => [
        'MBag' => [
            'descrizione' => 'La borsa a mano con chiusura clip clap',
            'colori' => [
                '/assets/images/m-bag-small/1.webp',
                '/assets/images/m-bag-large/1.webp',
                '/assets/images/m-bag-extra-large/1.webp',
                '/assets/images/disponibili-ora/3/3_1.webp',
                '/assets/images/disponibili-ora/6/6_1.webp',
            ],
        ],
    ],

    // Percorsi interni con la barra finale: Netlify serve /pagina/ e reindirizza /pagina (home, ancore e file restano uguali)
    'conBarra' => function ($page, $path) {
        $path = (string) $path;
        if ($path === '' || $path === '/' || str_contains($path, '#') || preg_match('/\.[a-z0-9]+$/i', $path)) {
            return $path === '' ? '/' : $path;
        }

        return rtrim($path, '/') . '/';
    },

    // srcset con le varianti -400/-800.webp create da scripts/ottimizza-immagini.py.
    // $maxWidth esclude le versioni più grandi (es. miniature); senza varianti resta l'originale.
    'srcset' => function ($page, $path, $maxWidth = null) {
        $info = pathinfo((string) $path);
        $candidati = [];
        foreach ([400, 800] as $larghezza) {
            $variante = $info['dirname'] . '/' . $info['filename'] . '-' . $larghezza . '.webp';
            if (($maxWidth === null || $larghezza <= $maxWidth) && is_file(__DIR__ . '/source' . $variante)) {
                $candidati[] = $variante . ' ' . $larghezza . 'w';
            }
        }
        $dimensioni = @getimagesize(__DIR__ . '/source' . $path);
        if ($dimensioni && ($maxWidth === null || $dimensioni[0] <= $maxWidth || $candidati === [])) {
            $candidati[] = $path . ' ' . $dimensioni[0] . 'w';
        }

        return implode(', ', $candidati);
    },

    'collections' => [
        'borse' => [
            'path' => 'modelli/{filename}',
            'sort' => 'ordine',
            'filter' => function ($page) {
                return (bool) ($page->get('visibile', true));
            },
            'getExcerpt' => function ($page, $length = 150) {
                if ($page->excerpt) {
                    return $page->excerpt;
                }
                
                $content = trim(preg_replace('/\s+/', ' ', preg_replace('#<[^>]+>#', ' ', (string) $page->getContent())));
                // mb_substr per non spezzare le lettere accentate; "…" solo se il testo viene tagliato
                return mb_strlen($content) > $length ? rtrim(mb_substr($content, 0, $length)) . '…' : $content;
            },
        ],
    ],
];
