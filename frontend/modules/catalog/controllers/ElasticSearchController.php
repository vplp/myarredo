<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    ElasticSearchProduct, ElasticSearchSale, ElasticSearchItalianProduct
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
    public function actionSearch()
    {
        //ElasticSearchProduct::updateMapping();

        $this->title = Yii::t('app', 'Search');

        $model = new ElasticSearchProduct();
        $modelSale = new ElasticSearchSale();
        $modelItalianProduct = new ElasticSearchItalianProduct();

        $queryParams = ArrayHelper::merge(['search' => ''], Yii::$app->request->queryParams);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));
        $modelsItalianProduct = $modelItalianProduct->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        $queryParams['country'] = Yii::$app->city->getCountryId();
        $queryParams['city'] = Yii::$app->city->getCityId();

        $modelsSale = $modelSale->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        return $this->render('search', [
            'queryParams' => $queryParams,
            'models' => $models,
            'modelsSale' => $modelsSale,
            'modelsItalianProduct' => $modelsItalianProduct,
        ]);
    }
}
