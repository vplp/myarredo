<?php

namespace frontend\modules\catalog\controllers;

use  Yii;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    ElasticSearchProduct, Product
};

/**
 * Class ElasticSearchController
 *
 * @package frontend\modules\catalog\controllers
 */
class ElasticSearchController extends BaseController
{
    public $title = "ElasticSearch";

    public $defaultAction = 'search';

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
//        $product = Product::findByAlias('pismennyj_stol_bakokko_palazzo_ducale_art_5036');
//
//        ElasticSearchProduct::addRecord($product);

        $model = ElasticSearchProduct::find()->all();

        var_dump($model);

        return $this->render('index');
    }

    /**
     * @inheritdoc
     */
    public function actionSearch()
    {
//        $value = Yii::$app->request->queryParams;
//
//        $params = [
//            'match' => [
//                'title' => $value['search'],
//            ]
//        ];
//
//        $model = ElasticSearchProduct::find()->query($params)->all();
//
//        var_dump($model);

        $model = new ElasticSearchProduct();

        $result = $model->search(Yii::$app->request->queryParams);

        $query = Yii::$app->request->queryParams;

        return $this->render('search', [
            'dataProvider' => $result,
            'query' => $query['search'],
        ]);

//        return $this->render('search', [
//            'searchModel' => $elastic,
//            'dataProvider' => $result,
//            'query' => $query['search'],
//        ]);
    }
}
