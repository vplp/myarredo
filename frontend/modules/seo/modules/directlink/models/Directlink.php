<?php

namespace frontend\modules\seo\modules\directlink\models;

use Yii;

/**
 * Class Directlink
 *
 * @package frontend\modules\seo\modules\directlink\models
 */
class Directlink extends \common\modules\seo\modules\directlink\models\Directlink
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @return $this
     */
    public static function findByUrl()
    {
        $url = Yii::$app->getRequest()->getUrl();
        $base_url = Yii::$app->getRequest()->getBaseUrl();

        $local_url = str_replace($base_url, '', $url);

        if (!empty($local_url)) {
            return Directlink::findBase()->url($local_url)->one();
        }

        return [];
    }
}