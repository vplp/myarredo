<?php

namespace backend\modules\payment\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\{Create, ListModel, Update};
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
                'create' => [
                    'class' => Create::class,
                ],
                'update' => [
                    'class' => Update::class,
                ],
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'filterModel' => $this->filterModel,
                ],
            ]
        );
    }
}
