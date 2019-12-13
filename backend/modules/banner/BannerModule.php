<?php

namespace backend\modules\banner;

use Yii;

/**
 * Class BannerModule
 *
 * @package backend\modules\banner
 */
class BannerModule extends \common\modules\banner\BannerModule
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'Banners',
                'icon' => 'fa-file-text',
                'position' => 4,
                'items' => [
                    [
                        'label' => 'Banners for factories',
                        'position' => 7,
                        'url' => ['/banner/banners-factory/list'],
                    ],
                    [
                        'label' => 'Banners for main',
                        'position' => 7,
                        'url' => ['/banner/banners-main/list'],
                    ],
                    [
                        'label' => 'Banners for catalog',
                        'position' => 7,
                        'url' => ['/banner/banners-catalog/list'],
                    ],
                    [
                        'label' => 'Background banners',
                        'position' => 7,
                        'url' => ['/banner/banners-background/list'],
                    ],
                ]
            ];
        }

        return $menuItems;
    }
}
