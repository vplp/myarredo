<?php

namespace backend\modules\catalog\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use thread\actions\{
    Create, Update
};
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    FactoryPromotion, search\FactoryPromotion as filterFactoryPromotion
};

/**
 * Class PromotionProductController
 *
 * @package backend\modules\catalog\controllers
 */
class PromotionProductController extends BackendController
{
    public $model = FactoryPromotion::class;
    public $filterModel = filterFactoryPromotion::class;

    public $title = 'Factory promotion';
    public $name = 'Factory promotion';

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
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
        ]);
    }
}
