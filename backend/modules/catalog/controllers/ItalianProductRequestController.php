<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\catalog\models\{
    ItalianProductRequest, search\ItalianProductRequest as filterItalianProductRequest
};
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, ListModel, Update
};

/**
 * Class ItalianProductRequestController
 *
 * @package backend\modules\catalog\controllers
 */
class ItalianProductRequestController extends BackendController
{
    public $model = ItalianProductRequest::class;

    public $filterModel = filterItalianProductRequest::class;

    public $title = 'Sale in Italy request';

    public $name = 'sale in italy request';

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

    /**
     * @return array
     */
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
