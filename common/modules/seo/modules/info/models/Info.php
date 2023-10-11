<?php

namespace common\modules\seo\modules\info\models;

/**
 * Class Info
 *
 * @package common\modules\seo\modules\info\models
 */
class Info extends \thread\modules\seo\modules\info\models\Info
{
    /**
     * @param $id
     */
    public static function findById($id)
    {
        return self::find()->byID($id)->one();
    }

    /**
     * @return mixed
     */
    public static function findAllWithLang()
    {
        return self::findBase()->joinWith(['lang'])->undeleted()->all();
    }
}
