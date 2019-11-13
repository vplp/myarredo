<?php

namespace frontend\modules\catalog\widgets\category;

use yii\base\Widget;
//
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
        $this->models = Category::getDb()->cache(function ($db) {
            return Category::findBase()->andWhere(['popular' => '1'])->all();
        }, 60 * 60);
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
