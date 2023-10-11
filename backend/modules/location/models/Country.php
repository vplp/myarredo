<?php

namespace backend\modules\location\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Country
 *
 * @package backend\modules\location\models
 */
class Country extends \common\modules\location\models\Country implements BaseBackendModel
{
    /**
     * @param array $IDs
     * @return array
     */
    public static function dropDownList($IDs = [])
    {
        $query = self::findBase();

        if ($IDs) {
            $query->byId($IDs);
        }

        $data = $query->undeleted()->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownListForRegistration($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $query = self::findBase()->andFilterWhere(['show_for_registration' => '1']);

        if ($IDs) {
            $query->byId($IDs);
        }

        $data = $query->all();

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Country())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Country())->trash($params);
    }
}
