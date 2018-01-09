<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
//    /**
//     * Example
//     */
//    'seo' => [
//        'class' => thread\modules\seo\Seo::class,
//        'params' => [
//            'map' => [
//                'hostInfo' => 'base',
//                'rules' => '@frontend/config/part/url-rules.php',
//                'filepath' => '@root/web/sitemap.xml'
//            ]
//        ],
//        'controllerMap' => [
//            'map-pathcache' => [
//                'class' => \thread\modules\seo\modules\pathcache\console\PathcacheController::class
//            ],
//            'map-fill' => [
//                'class' => \thread\modules\seo\modules\sitemap\console\FillController::class,
//                'hostInfo' => 'hostInfo'
//            ],
//            'map-create' => [
//                'class' => \thread\modules\seo\modules\sitemap\console\CreateController::class
//            ]
//        ],
//    ],
    'menu' => [
        'class' => thread\modules\menu\Menu::class
    ],
];
