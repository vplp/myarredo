<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\seo\models\Redirects;

/**
 * Class RedirectsController
 *
 * @package console\controllers
 */
class RedirectsController extends Controller
{
    public function actionAddToCache()
    {
        $this->stdout("SetCache: start. \n", Console::FG_GREEN);

        $models = Redirects::findBase()->asArray()->all();

        $cache = Yii::$app->redisCache;

        foreach ($models as $model) {
            $key = md5($model['url_from']);

            if (!$cache->exists($key)) {
                $cache->set($key, $model['url_to'], 60 * 60 * 3);
            }
        }

        $this->stdout("SetCache: finish. \n", Console::FG_GREEN);
    }
}
