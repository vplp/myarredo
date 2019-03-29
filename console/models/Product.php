<?php

namespace console\models;

/**
 * Class Product
 *
 * @package console\models
 */
class Product extends \frontend\modules\catalog\models\Product
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang', 'factory'])
            ->orderBy(self::tableName() . '.updated_at DESC')
            ->enabled()
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0'
            ]);
    }

    /**
     * @return mixed
     */
    public static function findBaseArray()
    {
        return self::findBase()
            ->asArray();
    }
}
