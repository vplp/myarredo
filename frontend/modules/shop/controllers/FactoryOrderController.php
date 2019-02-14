<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\web\ForbiddenHttpException;
//
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
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory' &&
            !Yii::$app->user->identity->profile->factory_id
        ) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied without factory id.'));
        }

        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                    'list-italy' => ['get'],
                    'view' => ['get'],
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

        $params = Yii::$app->request->queryParams;

        $params['product_type'] = 'product';

        $models = $model->search(
            ArrayHelper::merge(
                $params,
                [
                    'factory_id' => Yii::$app->user->identity->profile->factory_id
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

    /**
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionListItaly()
    {
        $model = new Order();

        $params = Yii::$app->request->queryParams;
        $params['product_type'] = 'sale-italy';

        $models = $model->search(
            ArrayHelper::merge(
                $params,
                [
                    'factory_id' => Yii::$app->user->identity->profile->factory_id
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
