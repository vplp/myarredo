<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Product, Category
};

/**
 * Class CategoryController
 *
 * @package frontend\modules\catalog\controllers
 */
class CategoryController extends BaseController
{
    public $label = "Category";
    public $title = "Category";
    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $model = new Product();

        $params = $group = [];

        if (Yii::$app->request->get('alias')) {
            $group = Category::findByAlias(Yii::$app->request->get('alias'));

            if ($group === null)
                throw new NotFoundHttpException;

            $this->label = $group['lang']['title'];

            $params['category'] = $group['id'];
        }

        $models = $model->search(ArrayHelper::merge($params, Yii::$app->request->queryParams));

        return $this->render('list', [
            'group' => $group,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}
