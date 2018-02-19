<?php

namespace frontend\modules\catalog\widgets\category;

use yii\base\Widget;
use frontend\modules\catalog\models\Category;

/**
 * Class CategoryOnMainPage
 *
 * @package frontend\modules\catalog\widgets\category
 */
class CategoryOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'category_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = Category::findBase()
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