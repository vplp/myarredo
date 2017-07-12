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

    public $menuItems = [
        'name' => 'Seo',
        'icon' => 'fa-file-text',
        'position' => 10,
        'items' =>
            [
                [
                    'name' => 'Robots.txt',
                    'position' => 1,
                    'url' => ['/seo/robots/update'],
                ],
                [
                    'name' => 'Direct Link',
                    'position' => 2,
                    'url' => ['/seo/directlink/directlink/list'],
                ],
                [
                    'name' => 'Base Info',
                    'position' => 2,
                    'url' => ['/seo/info/info/list'],
                ]
            ]
    ];
}