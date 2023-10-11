<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    //Migration
    'controllerMap' => [
        'map-pathcache' => [
            'class' => \thread\modules\seo\modules\pathcache\console\PathcacheController::class
        ],
        'map-fill' => [
            'class' => \thread\modules\seo\modules\sitemap\console\FillController::class
        ],
        'map-create' => [
            'class' => \thread\modules\seo\modules\sitemap\console\CreateController::class
        ]
    ],
];
