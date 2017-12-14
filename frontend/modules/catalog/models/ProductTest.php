<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class Product
 *
 * @package frontend\modules\catalog\models
 */
class ProductTest extends Product
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Yii::$app->get('db-cache');
    }
}