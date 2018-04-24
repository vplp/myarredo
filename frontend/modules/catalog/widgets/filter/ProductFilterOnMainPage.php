<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;
use yii\helpers\{
    Url, ArrayHelper
};
//
use frontend\modules\catalog\models\{
    Category, Types
};

/**
 * Class ProductFilterOnMainPage
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class ProductFilterOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_filter_on_main_page';

    /**
     * @var object
     */
    public $category = [];

    /**
     * @var object
     */
    public $types = [];

    /**
     * @return string
     * @throws \yii\base\ExitException
     */
    public function run()
    {
        $keys = Yii::$app->catalogFilter->keys;

        if (Yii::$app->getRequest()->post('filter_on_main_page')) {
            $category = Yii::$app->getRequest()->post('category');
            $types = Yii::$app->getRequest()->post('types');

            $params = Yii::$app->catalogFilter->params;

            $params[$keys['category']] = $category;
            $params[$keys['type']][] = $types;

            $link = Yii::$app->catalogFilter->createUrl($params, ['/catalog/category/list']);

            Yii::$app->response->redirect($link, 301);
            Yii::$app->end();
        }

        $category = ArrayHelper::map(Category::findBase()->all(), 'alias', 'lang.title');
        $types = ArrayHelper::map(Types::findBase()->all(), 'alias', 'lang.title');

        return $this->render($this->view, [
            'category' => $category,
            'types' => $types,
        ]);
    }
}