<?php

use TightenCo\Jigsaw\Jigsaw;

/** @var \Illuminate\Container\Container $container */
/** @var \TightenCo\Jigsaw\Events\EventBus $events */

$events->afterBuild(function (Jigsaw $jigsaw) {
    $dest = $jigsaw->getDestinationPath();

    foreach (['robots.txt', 'sitemap.xml'] as $filename) {
        $dir = $dest . '/' . $filename;
        $indexFile = $dir . '/index.html';

        if (is_dir($dir) && file_exists($indexFile)) {
            $content = file_get_contents($indexFile);
            unlink($indexFile);
            rmdir($dir);
            file_put_contents($dest . '/' . $filename, $content);
        }
    }
});
