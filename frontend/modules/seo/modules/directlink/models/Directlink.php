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
     * @param int $city_id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByUrl($city_id = 0)
    {
        $url = Yii::$app->getRequest()->getUrl();
        $base_url = Yii::$app->getRequest()->getBaseUrl();

        $local_url = str_replace($base_url, '', $url);

        $exp = explode('?', $local_url);

        $local_url = $exp[0];

        $result = [];

        if (!empty($local_url)) {
            $query = Directlink::findBase()->url($local_url);
            if ($city_id) {
                $query
                    ->joinWith(['cities'])
                    ->andWhere(['fv_seo_direct_link_rel_location_city.location_city_id' => $city_id]);
            }
            $result = $query->one();
        }

        return $result;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function getInfo()
    {
        $record = self::findByUrl(Yii::$app->city->getCityId());

        if ($record == null) {
            $record = self::findByUrl();
        }

        return $record;
    }
}
