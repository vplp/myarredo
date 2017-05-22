<?php

namespace backend\modules\seo;

use backend\modules\seo\modules\{
    directlink\Directlink, info\Info
};

/**
 * Class Seo
 *
 * @package backend\modules\seo
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Seo extends \common\modules\seo\Seo
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

    /**
     *
     */
    public function init()
    {

        $this->modules = [
            'info' => [
                'class' => Info::class,
            ],
            'directlink' => [
                'class' => Directlink::class
            ]
        ];

        parent::init();
    }
}
