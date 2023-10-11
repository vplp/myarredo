<?php

namespace common\modules\location\models;

use yii\helpers\ArrayHelper;

/**
 * Class Currency
 *
 * @package common\modules\location\models
 */
class Currency extends \thread\modules\location\models\Currency
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy(CurrencyLang::tableName() . '.title');
    }

    /**
     * @param integer $code1
     * @return mixed
     */
    public static function findByCode1($code1)
    {
        return self::findBase()->where(['code1' => $code1])->one();
    }

    /**
     * @param string $code2
     * @return mixed
     */
    public static function findByCode2($code2)
    {
        return self::findBase()->where(['code2' => $code2])->one();
    }

    /**
     * @return array
     */
    public static function getMapCode2Title()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'code2', 'lang.title');
    }
}
