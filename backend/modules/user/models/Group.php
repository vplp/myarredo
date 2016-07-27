<?php

namespace backend\modules\user\models;

use yii\data\ActiveDataProvider;

/**
 * Class Group
 *
 * @package admin\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Group extends \common\modules\user\models\Group
{

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Group)->search($params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Group)->trash($params);
    }

    /**
     * @return array|null
     */
    public static function all()
    {
        return self::find()->joinWith(['lang'])->undeleted()->all();
    }
}
