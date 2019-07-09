<?php

namespace frontend\modules\seo\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class MetricsController
 *
 * @package frontend\modules\seo\controllers
 */
class MetricsController extends Controller
{
    /**
     * @return array
     */
    public function actionAjaxGetMetrics()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;

            $html = $this->renderPartial('ajax_get_metrics');

            return ['success' => 1, 'html' => $html];
        }
    }
}
