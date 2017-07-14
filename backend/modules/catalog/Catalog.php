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
                    'name' => 'Group',
                    'position' => 1,
                    'url' => ['/catalog/category/list'],
                ],
                [
                    'name' => 'Types',
                    'position' => 2,
                    'url' => ['/catalog/types/list'],
                ],
                [
                    'name' => 'Product',
                    'position' => 3,
                    'url' => ['/catalog/product/list'],
                ]
            ]
    ];
}
