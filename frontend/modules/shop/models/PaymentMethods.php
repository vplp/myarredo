<?php

namespace frontend\modules\shop\models;

use yii\helpers\ArrayHelper;

/**
 * Class PaymentMethods
 *
 * @package frontend\modules\shop\models
 */
class PaymentMethods extends \common\modules\shop\models\PaymentMethods
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang'])->enabled();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findIdByAlias($alias)
    {
        return self::find()->byAlias($alias)->select('id')->enabled()->asarray()->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id)
    {
        return self::findBase()->andWhere([self::tableName() . '.id' => $id])->one();
    }

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'id', 'lang.title');
    }
}
