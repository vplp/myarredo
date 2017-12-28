<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
//
use frontend\components\BaseController;
use frontend\modules\shop\models\{
    Order
};

/**
 * Class AdminOrderController
 *
 * @package frontend\modules\shop\controllers
 */
class AdminOrderController extends BaseController
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
                    'list' => ['get'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list',
                        ],
                        'roles' => ['admin'],
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
     */
    public function actionList()
    {
        $model = new Order();

        $models = $model->search(Yii::$app->request->queryParams);

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
