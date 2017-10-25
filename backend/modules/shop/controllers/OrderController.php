<?php
namespace backend\modules\shop\controllers;

use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
//
use thread\actions\{
    ListModel, Update
};

use backend\modules\shop\models\{
    Order, search\OrderItem as filterOrderItemModel
};


/**
 * Class OrderController
 *
 * @package backend\modules\location\controllers
 */
class OrderController extends BackendController
{
    public $model = Order::class;
    public $filterModel = filterOrderItemModel::class;
    public $title = 'Order';
    public $name = 'Order';

    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'update' => [
                    'class' => Update::class,
                    'modelClass' => $this->model,
                    'scenario' => 'backend',
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id
                        ];
                    }
                ],
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    //'layout' => '@app/layouts/rud-trash',
                ],
            ]
        );
    }

}