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
        return parent::findBase()->enabled();
    }

    /**
     * @return mixed
     */
    public static function getMapCode2Course()
    {
        return ArrayHelper::map(self::findBase()->all(), 'code2', 'course');
    }
}
