<?php

namespace backend\modules\payment\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\{ListModel};
use thread\app\base\controllers\BackendController;
//
use backend\modules\payment\models\{
    Payment, search\Payment as filterPaymentModel
};

/**
 * Class PaymentController
 *
 * @package backend\modules\payment\controllers
 */
class PaymentController extends BackendController
{
    public $model = Payment::class;
    public $filterModel = filterPaymentModel::class;
    public $title = 'Payment';
    public $name = 'payment';

    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'layout' => 'list',
                    'filterModel' => $this->filterModel,
                ],
            ]
        );
    }
}
