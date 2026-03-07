<?php

return [
    'production' => false,
    'baseUrl' => '',
    'title' => 'M Crochet Lab',
    'description' => 'Borse all\'uncinetto fatte a mano con passione',
    'collections' => [
        'borse' => [
            'path' => 'modelli/{filename}',
            'sort' => 'ordine',
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
