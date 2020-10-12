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
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang', 'factory'])
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0'
            ])
            ->orderBy(self::tableName() . '.updated_at DESC')
            ->enabled();
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
