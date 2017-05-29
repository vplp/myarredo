<?php

namespace frontend\modules\seo\modules\pathcache\models;

/**
 * Class Pathcache
 *
 * @package frontend\modules\seo\modules\pathcache\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Pathcache extends \common\modules\seo\modules\pathcache\models\Pathcache
{
    /**
     * @param string $classname
     * @return mixed
     */
    public static function findByClassName(string $classname)
    {
        return self::find()->_classname($classname);
    }

    /**
     * @param string $classname
     * @return mixed
     */
    public static function getByClassName(string $classname)
    {
        return self::find()->_classname($classname)->one();
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return self::find()->enabled()->asArray()->all();
    }
}
