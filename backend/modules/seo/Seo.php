<?php

namespace backend\modules\seo;

use common\modules\seo\Seo as CommonSeoModule;

/**
 * Class Seo
 *
 * @package backend\modules\seo
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Seo extends CommonSeoModule
{
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Seo',
        'icon' => 'fa-users',
        'position' => 6,
        'items' => [
            [
                'name' => 'Seo',
                'icon' => 'fa-tasks',
                'url' => ['/seo/seo/list'],
            ],
            [
                'name' => 'Robots.txt',
                'icon' => 'fa-tasks',
                'url' => ['/seo/robots/update'],
            ],
        ]
    ];
}
