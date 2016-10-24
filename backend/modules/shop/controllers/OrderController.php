<?php
namespace backend\modules\shop\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\shop\models\{
    Order, search\Order as filterOrderModel
};
use thread\actions\{
    ListModel, Update
};
use yii\helpers\ArrayHelper;

/**
 * Class OrderController
 *
 * @package backend\modules\location\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class OrderController extends BackendController
{
    public $model = Order::class;
    public $filterModel = filterOrderModel::class;
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
                    'scenario' => 'published',
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
                    'layout' => '@app/layouts/rud-trash',
                ],
            ]
        );
    }

}