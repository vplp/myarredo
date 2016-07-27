<?php

namespace backend\modules\location\models;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */

class Company extends \common\modules\location\models\Company
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

}
