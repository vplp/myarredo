<?php

namespace frontend\modules\shop\widgets\request;

use Yii;
use yii\helpers\Url;
use yii\base\Widget;
use frontend\modules\shop\models\{
    CartCustomerForm,
    Order,
    search\Order as SearchOrder
};

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

        return $this->render($this->view, [
            'model' => $model,
            'product_id' => $this->product_id,
        ]);
    }
}
