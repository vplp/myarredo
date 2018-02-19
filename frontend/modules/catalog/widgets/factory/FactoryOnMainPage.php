<?php

namespace frontend\modules\catalog\widgets\factory;

use yii\base\Widget;
use frontend\modules\catalog\models\Factory;

/**
 * Class FactoryOnMainPage
 *
 * @package frontend\modules\catalog\widgets\factory
 */
class FactoryOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'factory_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = Factory::findBase()
            ->andWhere(['popular' => '1'])
            ->cache(7200)
            ->all();
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