<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Factory
};

/**
 * Class FactoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryController extends BaseController
{
    public $label = "Factory";
    public $title = "Factory";
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
        $model = new Factory();

        $params = [];

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));
        $view = Yii::$app->request->get('view');

        if ($view && $view !== 'three') {
            throw new NotFoundHttpException;
        }

        if ($view == 'three') {
            foreach ($models->getModels() as $obj) {
                $_models[$obj['first_letter']][] = $obj;
            }
            return $this->render('list_three', [
                'models' => $_models,
                'pages' => $models->getPagination(),
            ]);
        } else {
            return $this->render('list', [
                'models' => $models->getModels(),
                'pages' => $models->getPagination(),
            ]);
        }

    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(string $alias)
    {
        $model = Factory::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
