<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\{
    ProductStats, Factory
};
use frontend\components\BaseController;

/**
 * Class ProductStatsController
 *
 * @package frontend\modules\catalog\controllers
 */
class ProductStatsController extends BaseController
{
    public $label = "Stats";
    public $title = "Stats";
    public $defaultAction = 'list';

    public function actionList()
    {
        $model = new ProductStats();

        $params = [];

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        return $this->render('list', [
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
        ]);
    }
}