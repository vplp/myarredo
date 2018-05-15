<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\Search;
use frontend\modules\catalog\models\{
    Collection, Product, Category, Factory, Types, Specification
};

/**
 * Class SearchController
 *
 * @package frontend\modules\catalog\controllers
 */
class SearchController extends BaseController
{
    public $title = "Search";

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
                    'list' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $elastic = new Search();

        $result = $elastic->Searches(Yii::$app->request->queryParams);

        $query = Yii::$app->request->queryParams;

        return $this->render('list', [
            'searchModel' => $elastic,
            'dataProvider' => $result,
            'query' => $query['search'],
        ]);
    }
}
