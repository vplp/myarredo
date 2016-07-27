<?php

namespace backend\modules\location\models;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */

class Currency extends \common\modules\location\models\Currency
{
    /**
     * Find base Page object for current language active and undeleted
     *
     * @return ActiveQuery
     */
    public static function findBase()
    {
        return parent::findBase()->_lang()->enabled();
    }

    /**
     * Find ONE Model object in array by its alias
     *
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->alias($alias)->asArray()->one();
    }
}
