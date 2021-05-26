<?php

namespace frontend\modules\seo\models;

use Yii;

/**
 * Class Redirects
 *
 * @package frontend\modules\seo\models
 */
class Redirects extends \common\modules\seo\models\Redirects
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @throws \yii\base\ExitException
     */
    public static function findRedirect()
    {
        if (Yii::$app->getRequest()->getUserIP() != '127.0.0.1') {
            $cache = Yii::$app->redisCache;

            $key = md5($_SERVER['REQUEST_URI']);
            if ($cache->exists($key)) {
                Yii::$app->response->redirect($cache->get($key), 301);
                yii::$app->end();
            }
        } else {
            $data = self::findBase()
                ->andWhere(['url_from' => $_SERVER['REQUEST_URI']])
                ->asArray()
                ->one();

            if ($data != null) {
                Yii::$app->response->redirect($data['url_to'], 301);
                yii::$app->end();
            }
        }
    }
}
