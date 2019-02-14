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

        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin', 'catalogEditor'])) {
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
                        'label' => 'Types',
                        'position' => 4,
                        'url' => ['/catalog/types/list'],
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
                ]
            ];
        }

        return $menuItems;
    }
}
