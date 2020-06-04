<?php

namespace frontend\modules\shop\widgets\request;

use Yii;
use yii\base\Widget;
use frontend\modules\shop\models\CartCustomerForm;

/**
 * Class RequestNotFound
 *
 * @package frontend\modules\shop\widgets\cart
 */
class RequestNotFound extends Widget
{
    public $view = 'request_not_found';

    /**
     * @return string
     */
    public function run()
    {
        $model = new CartCustomerForm();

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
