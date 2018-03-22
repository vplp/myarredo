<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\{
    VerbFilter, AccessControl
};
use frontend\components\BaseController;
use frontend\modules\shop\models\{
    Order
};

/**
 * Class FactoryOrderController
 *
 * @package frontend\modules\shop\controllers
 */
class FactoryOrderController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get', 'post'],
                    'view' => ['get', 'post'],
                ],
            ],
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
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new Order();

        $models = $model->search(
            ArrayHelper::merge(
                Yii::$app->request->queryParams,
                [
                    'factory_id' => Yii::$app->getUser()->getIdentity()->profile->factory_id
                ]
            )
        );

        $this->title = Yii::t('app', 'Orders');

        $this->breadcrumbs[] = [
            'label' => $this->title,
        ];

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination()
        ]);
    }
}
