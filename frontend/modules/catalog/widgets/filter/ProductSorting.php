<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;

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
        'all' => 'Все товары',
        'null' => 'Все композиции',
    ];

    /**
     * @return string
     */
    public function run()
    {
        $this->sortList = [
            'null' => Yii::t('app', 'Не выбрано'),
            'asc' => Yii::t('app', 'По возрастанию'),
            'desc' => Yii::t('app', 'По убыванию'),
        ];
        $this->objectList = [
            'all' => Yii::t('app', 'Все товары'),
            'null' => Yii::t('app', 'Все композиции'),
        ];

        return $this->render($this->view, [
            'sortList' => $this->sortList,
            'objectList' => $this->objectList,
            'url' => Yii::$app->catalogFilter->createUrl(Yii::$app->catalogFilter->params)
        ]);
    }
}
