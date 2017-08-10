<?php

namespace frontend\modules\catalog\widgets\product;

use yii\base\Widget;

/**
 * Class ProductSorting
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductSorting extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_sorting';

    /**
     * @var array
     */
    public $sortList = [
        '' => 'Не выбрано',
        'asc' => 'По возрастанию',
        'desc' => 'По убыванию',
    ];

    /**
     * @var array
     */
    public $objectList = [
        '' => 'Все товары',
        'composition' => 'Все композиции',
    ];

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, [
            'sortList' => $this->sortList,
            'objectList' => $this->objectList
        ]);
    }
}