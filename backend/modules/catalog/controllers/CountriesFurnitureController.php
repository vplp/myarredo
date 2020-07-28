<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\catalog\models\{
    CountriesFurniture
};
use thread\app\base\controllers\BackendController;
use thread\actions\{
    ListModel
};

/**
 * Class CountriesFurnitureController
 *
 * @package backend\modules\catalog\controllers
 */
class CountriesFurnitureController extends BackendController
{
    public $model = CountriesFurniture::class;

    public $filterModel = CountriesFurniture::class;

    public $title = 'Countries furniture';

    public $name = 'Countries furniture';

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
                'layout' => 'list-countries-furniture'
            ],
        ]);
    }
}
