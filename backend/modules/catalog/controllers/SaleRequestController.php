<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\catalog\models\{
    SaleRequest, search\SaleRequest as filterSaleRequest
};
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, ListModel, Update
};

/**
 * Class SaleRequestController
 *
 * @package backend\modules\catalog\controllers
 */
class SaleRequestController extends BackendController
{
    public $model = SaleRequest::class;

    public $filterModel = filterSaleRequest::class;

    public $title = 'Sale request';

    public $name = 'sale request';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'catalogEditor'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,

            ],
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
        ]);
    }
}
