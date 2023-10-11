<?php

namespace frontend\modules\location\models;

use yii\helpers\ArrayHelper;

/**
 * Class Currency
 *
 * @package frontend\modules\location\models
 */
class Currency extends \common\modules\location\models\Currency
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
        return parent::findBase()->asArray()->enabled();
    }

    /**
     * @param string $code2
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByCode2($code2)
    {
        $result = self::getDb()->cache(function ($db) use ($code2) {
            return self::findBase()->andWhere(['code2' => $code2])->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getMapCode2Course()
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBase()->all();
        }, 60 * 60);

        return ArrayHelper::map($result, 'code2', 'course');
    }
}
