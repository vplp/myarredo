<?php

namespace backend\modules\news\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\news\models\Group as CommonGroupModel;

/**
 * Class Group
 *
 * @package backend\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends CommonGroupModel implements BaseBackendModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function getDropdownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Group())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Group())->trash($params);
    }

    /**
     * @return mixed
     */
    public function getArticlesCount()
    {
        return $this->getArticles()->count();
    }
}
