<?php

namespace backend\modules\catalog;

use Yii;

/**
 * Class Catalog
 *
 * @package backend\modules\catalog
 */
class Catalog extends \common\modules\catalog\Catalog
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 50;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])) {
            $menuItems = [
                'label' => 'Catalog',
                'icon' => 'fa-file-text',
                'position' => 4,
                'items' => [
                    [
                        'label' => 'Product',
                        'position' => 1,
                        'url' => ['/catalog/product/list'],
                    ],
                    [
                        'label' => 'Product without specification',
                        'position' => 1,
                        'url' => ['/catalog/product-without-specification/list'],
                    ],
                    [
                        'label' => 'Product without prices',
                        'position' => 1,
                        'url' => ['/catalog/product-without-prices/list'],
                    ],
                    [
                        'label' => 'Product without price list',
                        'position' => 1,
                        'url' => ['/catalog/product-without-price-list/list'],
                    ],
                    [
                        'label' => 'Factory product',
                        'position' => 1,
                        'url' => ['/catalog/factory-product/list'],
                    ],
                    [
                        'label' => 'Compositions',
                        'position' => 2,
                        'url' => ['/catalog/compositions/list'],
                    ],
                    [
                        'label' => 'Category',
                        'position' => 3,
                        'url' => ['/catalog/category/list'],
                    ],
                    [
                        'label' => 'Предметы',
                        'position' => 4,
                        'url' => ['/catalog/types/list'],
                    ],
                    [
                        'label' => Yii::t('app', 'Colors'),
                        'position' => 4,
                        'url' => ['/catalog/colors/list'],
                    ],
                    [
                        'label' => 'Samples',
                        'position' => 5,
                        'url' => ['/catalog/samples/list'],
                    ],
                    [
                        'label' => 'Specification',
                        'position' => 6,
                        'url' => ['/catalog/specification/list'],
                    ],
                    [
                        'label' => 'Factory',
                        'position' => 7,
                        'url' => ['/catalog/factory/list'],
                    ],
                    [
                        'label' => 'Sale',
                        'position' => 7,
                        'url' => ['/catalog/sale/list'],
                    ],
                    [
                        'label' => 'Sale in Italy',
                        'position' => 7,
                        'url' => ['/catalog/sale-italy/list'],
                    ],
                    [
                        'label' => 'Countries furniture',
                        'position' => 7,
                        'url' => ['/catalog/countries-furniture/list'],
                    ],
                ]
            ];
        } elseif (in_array(Yii::$app->user->identity->group->role, ['seo'])) {
            $menuItems = [
                'label' => 'Catalog',
                'icon' => 'fa-file-text',
                'position' => 4,
                'items' => [
                    [
                        'label' => 'Factory',
                        'position' => 7,
                        'url' => ['/catalog/factory/list'],
                    ],
                ]
            ];
        }

        return $menuItems;
    }
}
