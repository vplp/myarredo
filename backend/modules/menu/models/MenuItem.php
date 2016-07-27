<?php

namespace backend\modules\menu\models;

/**
 * @author Fantamas
 */
class MenuItem extends \common\modules\menu\models\MenuItem
{
    /**
     * Find base Item object for current language active and undeleted
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->_lang()->enabled();
    }
}
