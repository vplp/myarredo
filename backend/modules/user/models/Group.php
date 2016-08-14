<?php

namespace backend\modules\user\models;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Group
 *
 * @package admin\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends \common\modules\user\models\Group implements BaseBackendModel
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

    /**
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'id', 'lang.title');
    }
}
