<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    Elastic, Search
};

/**
 * Class ElasticSearchController
 *
 * @package frontend\modules\catalog\controllers
 */
class ElasticController extends BaseController
{
    public $title = "ElasticSearch";

    public $defaultAction = 'search';

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
//        $elastic = new Elastic();
//
//        $elastic->alias = 'title-test';
//
//        if ($elastic->insert(true, null, ['op_type' => 'index'])) {
//            echo "Added Successfully";
//        } else {
//            echo "Error";
//        }

        return $this->render('index');
    }

    /**
     * @inheritdoc
     */
    public function actionSearch()
    {
        $elastic = new Search();

        $result = $elastic->Searches(Yii::$app->request->queryParams);
        $query = Yii::$app->request->queryParams;

        return $this->render('search', [
            'searchModel' => $elastic,
            'dataProvider' => $result,
            'query' => $query['search'],
        ]);
    }
}
