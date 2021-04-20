<?php

namespace backend\modules\shop;

use Yii;

/**
 * Class Shop
 *
 * @package backend\modules\shop
 */
class Shop extends \common\modules\shop\Shop
{
    public $itemOnPage = 100;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'Shop',
                'icon' => 'fa-map-marker',
                'position' => 6,
                'items' => [
                    [
                        'label' => 'Factory promotion',
                        'position' => 1,
                        'url' => ['/catalog/promotion-product/list'],
                    ],
                    [
                        'label' => 'Sale request',
                        'position' => 2,
                        'url' => ['/catalog/sale-request/list'],
                    ],
                    [
                        'label' => 'Sale in Italy request',
                        'position' => 3,
                        'url' => ['/catalog/italian-product-request/list'],
                    ],
                    [
                        'label' => 'Orders',
                        'position' => 4,
                        'url' => ['/shop/order/list'],
                    ]
                ]
            ];
        } elseif (in_array(Yii::$app->user->identity->group->role, ['settlementCenter'])) {
            $menuItems = [
                'label' => 'Shop',
                'icon' => 'fa-map-marker',
                'position' => 6,
                'items' => [
                    [
                        'label' => 'Orders',
                        'position' => 4,
                        'url' => ['/shop/order/list'],
                    ]
                ]
            ];
        }

        return $menuItems;
    }
}
