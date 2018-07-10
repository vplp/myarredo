<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPromotion,
    search\FactoryPromotion as filterFactoryPromotionModel
};
//
use thread\actions\{
    Create,
    ListModel,
    AttributeSwitch,
    Update
};

/**
 * Class FactoryPromotionController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryPromotionController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = FactoryPromotion::class;
    protected $modelLang = FactoryPromotionLang::class;
    protected $filterModel = filterFactoryPromotionModel::class;

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
                        'roles' => ['factory'],
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
        $this->title = Yii::t('app', 'Рекламная компания');

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'filterModel' => $this->filterModel,
                ],
                'create' => [
                    'class' => Create::class,
                    'modelClass' => $this->model,
                    'scenario' => 'frontend',
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
                'update' => [
                    'class' => Update::class,
                    'modelClass' => $this->model,
                    'scenario' => 'frontend',
                    'redirect' => function () {
                        return ['update', 'id' => $this->action->getModel()->id];
                    }
                ],
                'intrash' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'deleted',
                    'redirect' => $this->defaultAction,
                ],
            ]
        );
    }
}
