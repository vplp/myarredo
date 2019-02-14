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

        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'Shop',
                'icon' => 'fa-map-marker',
                'position' => 6,
                'items' => [
//            [
//                'label' => 'Delivery Methods',
//                'icon' => 'fa-tasks',
//                'url' => ['/shop/delivery-methods/list'],
//            ],
//            [
//                'label' => 'Payment Methods',
//                'icon' => 'fa-tasks',
//                'url' => ['/shop/payment-methods/list'],
//            ],
                    [
                        'label' => 'Factory promotion',
                        'position' => 1,
                        'url' => ['/catalog/factory-promotion/list'],
                    ],
                    [
                        'label' => 'Orders',
                        'position' => 2,
                        'url' => ['/shop/order/list'],
                    ]
                ]
            ];
        }

        return $menuItems;
    }
}
