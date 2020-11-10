<?php

namespace frontend\modules\shop\widgets\request;

use Yii;
use yii\base\Widget;
use frontend\modules\shop\models\FormFindProduct;

/**
 * Class RequestFindProduct
 *
 * @package frontend\modules\shop\widgets\cart
 */
class RequestFindProduct extends Widget
{
    public $view = 'request_find_product';

    /**
     * @return string
     */
    public function run()
    {
        $model = new FormFindProduct();
        $model->setScenario('frontend');

        $model->load(Yii::$app->getRequest()->post());

        $session = Yii::$app->session;

        $model->email = $session->get('order_email');
        $model->phone = $session->get('order_phone');
        $model->full_name = $session->get('order_full_name');

        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}
