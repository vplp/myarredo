<?php

namespace backend\modules\seo\models;
use common\modules\seo\models\Seo as CommonSeoModel;

/**
 * @author Fantamas
 */
class Seo extends CommonSeoModel
{
    /**
     * Find base Seo object for current language active and undeleted
     *
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->_lang()->enabled();
    }

}
