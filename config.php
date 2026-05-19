<?php

return [
    'production' => false,
    'baseUrl' => '',
    'title' => 'M Crochet Lab',
    'description' => 'Borse all\'uncinetto fatte a mano con passione',
    'shipping' => [
        'preparationTime' => '5-8 giorni lavorativi',
        'deliveryTime' => '24-72 ore dopo la spedizione',
        'tracking' => 'Codice inviato appena parte il pacco',
        'customOrders' => 'Tempi comunicati prima della conferma',
        'costs' => 'I costi vengono indicati prima della conferma ordine in base al peso, al volume e alla destinazione.',
    ],
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

    'promoAttiva' => true,
    'promoScadenza' => '2026-05-19',
    'promoBarra' => '🎁 Offerta di lancio: spedizione gratuita + un regalo misterioso per ogni ordine!',

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
                
                $content = preg_replace('#<[^>]+>#', ' ', $page->getContent());
                return trim(substr($content, 0, $length)) . '...';
            },
        ],
    ],
];
