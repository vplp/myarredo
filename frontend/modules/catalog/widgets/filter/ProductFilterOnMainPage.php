<?php

namespace frontend\modules\catalog\widgets\filter;

use Yii;
use yii\base\Widget;
use frontend\modules\catalog\models\{
    Product
};

/**
 * Class ProductFilterOnMainPage
 *
 * @package frontend\modules\catalog\widgets\filter
 */
class ProductFilterOnMainPage extends Widget
{
    /**
     * @var object
     */
    public $model = [];

    /**
     * @var string
     */
    public $view = 'product_filter_on_main_page';

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
            $price = Yii::$app->getRequest()->post('price');

            $params = Yii::$app->catalogFilter->params;

            if ($category) {
                $params[$keys['category']] = $category;
            }

            if ($types) {
                $params[$keys['type']][] = $types;
            }

            if (!empty($price['from']) && !empty($price['to'])) {
                $params[$keys['price']] = $price;
            } elseif (empty($price['from']) && !empty($price['to'])) {
                $price['from'] = number_format(1, 0, '.', '');
                $params[$keys['price']] = $price;
            } elseif (!empty($price['from']) && empty($price['to'])) {
                $price['to'] = number_format(Product::findBase()->max('price_from'), 0, '.', '');
                $params[$keys['price']] = $price;
            }

            Yii::$app->session->set('currency', $price['currency']);

            $link = Yii::$app->catalogFilter->createUrl($params, ['/catalog/category/list']);

            Yii::$app->response->redirect($link, 301);
            Yii::$app->end();
        }

        return $this->render($this->view, ['model' => $this->model]);
    }
}
