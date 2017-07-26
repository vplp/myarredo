<?php

namespace backend\modules\catalog;

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
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Catalog',
        'icon' => 'fa-file-text',
        'position' => 4,
        'items' =>
            [
                [
                    'name' => 'Product',
                    'position' => 1,
                    'url' => ['/catalog/product/list'],
                ],
                [
                    'name' => 'Compositions',
                    'position' => 2,
                    'url' => ['/catalog/compositions/list'],
                ],
                [
                    'name' => 'Category',
                    'position' => 3,
                    'url' => ['/catalog/category/list'],
                ],
                [
                    'name' => 'Types',
                    'position' => 4,
                    'url' => ['/catalog/types/list'],
                ],

                [
                    'name' => 'Samples',
                    'position' => 5,
                    'url' => ['/catalog/samples/list'],
                ],
                [
                    'name' => 'Specification',
                    'position' => 6,
                    'url' => ['/catalog/specification/list'],
                ],
                [
                    'name' => 'Factory',
                    'position' => 7,
                    'url' => ['/catalog/factory/list'],
                ],
            ]
    ];
}
