<?php

namespace backend\modules\shop;

/**
 * Class Shop
 *
 * @package backend\modules\shop
 */
class Shop extends \common\modules\shop\Shop
{
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Shop',
        'icon' => 'fa-map-marker',
        'position' => 6,
        'items' => [
            [
                'name' => 'Delivery Methods',
                'icon' => 'fa-tasks',
                'url' => ['/shop/delivery-methods/list'],
            ],
            [
                'name' => 'Payment Methods',
                'icon' => 'fa-tasks',
                'url' => ['/shop/payment-methods/list'],
            ],
            [
                'name' => 'Orders',
                'icon' => 'fa-tasks',
                'url' => ['/shop/order/list'],
            ]
        ]
    ];
}
