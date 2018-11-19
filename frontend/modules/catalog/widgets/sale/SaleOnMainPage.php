<?php

namespace frontend\modules\catalog\widgets\sale;

use yii\base\Widget;
use frontend\modules\catalog\models\Sale;

/**
 * Class SaleOnMainPage
 *
 * @package frontend\modules\catalog\widgets\sale
 */
class SaleOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'sale_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = Sale::findBase()
            ->andWhere(['on_main' => '1'])
            ->cache(7200)
            ->all();

        if ($this->models != null) {
            $i = 0;
            foreach ($this->models as $key => $model) {
                if ($key % 3 == 0) {
                    $i++;
                }
                $_models[$i][] = $model;
            }
            $this->models = $_models;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'models' => $this->models
            ]
        );
    }
}