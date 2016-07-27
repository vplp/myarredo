<?php

namespace backend\modules\menu\models;

/**
 * @author Fantamas
 */
class Menu extends \common\modules\menu\models\Menu
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
