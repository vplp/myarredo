<?php

namespace backend\modules\seo\models;

use common\modules\seo\models\Seo as CommonSeoModel;

/**
 * Class Seo
 *
 * @package backend\modules\seo\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
        return parent::findBase()->undeleted();
    }

}
