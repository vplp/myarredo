<?php

namespace api\modules\shop\controllers;

use api\components\RestController;
use api\modules\shop\actions\{
    OrderAcceptAction, OrderStatusAction
};
use api\modules\shop\models\Order;

/**
 * Class OrderController
 *
 * @package api\modules\shop\controllers
 */
class OrderController extends RestController
{
    public $modelClass = Order::class;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'accept' => [
                'class' => OrderAcceptAction::class,
                'modelClass' => $this->modelClass,
                'scenario' => 'addNewOrder',
            ],
            'status' => [
                'class' => OrderStatusAction::class,
                'modelClass' => $this->modelClass
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'accept' => ['POST'],
            'status' => ['POST']
        ];
    }
}
