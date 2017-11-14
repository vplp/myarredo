<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class ProductSorting
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class ProductSorting extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_sorting';

    public $url;
    /**
     * @var array
     */
    public $sortList = [
        'null' => 'Не выбрано',
        'asc' => 'По возрастанию',
        'desc' => 'По убыванию',
    ];

    /**
     * @var array
     */
    public $objectList = [
        'null' => 'Все товары',
        'composition' => 'Все композиции',
    ];

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, [
            'sortList' => $this->sortList,
            'objectList' => $this->objectList,
            'url' => Yii::$app->catalogFilter->createUrl(Yii::$app->catalogFilter->params)
        ]);
    }
}
