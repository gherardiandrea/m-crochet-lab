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
            'nome' => 'EBag',
            'colore' => 'Grigio',
            'prezzo' => '35€',
            'gallery' => [
                '/assets/images/e-bag/e_bag_grigia_7.webp',
                '/assets/images/e-bag/e_bag_grigia_2.webp',
                '/assets/images/e-bag/e_bag_grigia_3.webp',
            ],
        ],
        [
            'nome' => 'MBag Small',
            'colore' => 'Blu',
            'prezzo' => '55€',
            'gallery' => [
                '/assets/images/m-bag-small/1.webp',
                '/assets/images/m-bag-small/2.webp',
            ],
        ],
        [
            'nome' => 'MBag Large',
            'colore' => 'Naturale',
            'prezzo' => '85€',
            'gallery' => [
                '/assets/images/m-bag-large/1.webp',
                '/assets/images/m-bag-large/2.webp',
                '/assets/images/m-bag-large/3.webp',
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
