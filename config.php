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
