<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use thread\actions\RecordView;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Sale
};

/**
 * Class SaleController
 *
 * @package frontend\modules\catalog\controllers
 */
class SaleController extends BaseController
{
    public $label = "Sale";
    public $title = "Sale";
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
                    'view' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList()
    {
        $model = new Sale();

        $params = [];

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'view' => [
                'class' => RecordView::class,
                'modelClass' => Sale::class,
                'methodName' => 'findByAlias',
            ],
        ];
    }
}
