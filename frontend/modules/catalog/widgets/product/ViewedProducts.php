<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
//
use yii\base\Widget;
//
use frontend\modules\catalog\models\Product;

/**
 * Class ViewedProducts
 *
 * @package frontend\modules\catalog\widgets\products
 */
class ViewedProducts extends Widget
{
    /**
     * @var string
     */
    public $view = 'viewed_products';

    /**
     * @var object
     */
    protected $model = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $ids = [];
        if (isset(Yii::$app->request->cookies['viewed_products'])) {
            $ids = unserialize(Yii::$app->request->cookies->getValue('viewed_products'));
        }

        $this->model = Product::findBase()->byID($ids)->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'products' => $this->model
            ]
        );
    }
}
