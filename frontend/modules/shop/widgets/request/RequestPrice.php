<?php

namespace frontend\modules\shop\widgets\request;

use Yii;
use yii\base\Widget;
use frontend\modules\shop\models\CartCustomerForm;

/**
 * Class RequestPrice
 *
 * @package frontend\modules\shop\widgets\cart
 */
class RequestPrice extends Widget
{
    public $view = 'request_price_form_product';

    public $product_id = 0;

    /**
     * @return string
     */
    public function run()
    {
        $model = new CartCustomerForm;
        $model->setScenario('frontend');

        $model->load(Yii::$app->getRequest()->post());

        return $this->render($this->view, [
            'model' => $model,
            'product_id' => $this->product_id,
        ]);
    }
}
