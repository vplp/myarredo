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
    public function actionSetCache()
    {
        $this->stdout("SetCache: start. \n", Console::FG_GREEN);

        $models = Redirects::findBase()->asArray()->all();

        $cache = Yii::$app->redisCache;

        foreach ($models as $model) {
            $key = md5($model['url_from']);
            if ($cache->exists($key)) {
                $cache->set($key, $model['url_to'], 60);
            } else {
                $cache->set($key, $model['url_to'], 60);
            }
        }

        $this->stdout("SetCache: finish. \n", Console::FG_GREEN);
    }

    public function actionDeleteCache()
    {
        $this->stdout("DeleteCache: start. \n", Console::FG_GREEN);

        $cache = Yii::$app->redisCache;

        $cache->delete($cache->keys('*'));

        $this->stdout("DeleteCache: finish. \n", Console::FG_GREEN);
    }
}
