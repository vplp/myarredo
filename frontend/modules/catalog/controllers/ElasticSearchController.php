<?php

namespace frontend\modules\catalog\controllers;

use  Yii;
use yii\helpers\ArrayHelper;
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
    public function actionSearch()
    {
        $model = new ElasticSearchProduct();

        $queryParams = ArrayHelper::merge(['search' => ''], Yii::$app->request->queryParams);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        $this->title = Yii::t('app', 'Search');

        return $this->render('search', [
            'queryParams' => $queryParams,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}
