<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    ElasticSearchProduct
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
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');

        //ElasticSearchProduct::updateMapping();
        $this->title = Yii::t('app', 'Search');

        $model = new ElasticSearchProduct();

        $queryParams = ArrayHelper::merge(['search' => ''], Yii::$app->request->queryParams);

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

        return $this->render('search', [
            'queryParams' => $queryParams,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}
