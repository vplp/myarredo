<?php

namespace common\modules\page\models;

/**
 * Class Page
 *
 * @package common\modules\page\models
 */
class Page extends \thread\modules\page\models\Page
{
    /** Для сео виджета */
    const COMMON_NAMESPACE = self::class;

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang']);
    }
}
