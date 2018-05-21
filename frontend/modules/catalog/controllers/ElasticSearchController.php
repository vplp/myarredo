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
        //ElasticSearchProduct::updateMapping();

        //$product = ElasticSearchProduct::deleteRecord(82111);
        //$product = Product::findByAlias('pismennyj_stol_bakokko_palazzo_ducale_art_5036');
//
//        ElasticSearchProduct::addRecord($product);
//
//        $model = ElasticSearchProduct::find()->all();
//
//        var_dump($model);

        return $this->render('index');
    }

    /**
     * @inheritdoc
     */
    public function actionSearch()
    {
        $model = new ElasticSearchProduct();

        $models = $model->search(Yii::$app->request->queryParams);

        $query = Yii::$app->request->queryParams;

        $this->title = Yii::t('app', 'Search');

        return $this->render('search', [
            'query' => $query['search'],
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}
