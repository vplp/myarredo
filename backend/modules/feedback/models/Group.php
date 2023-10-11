<?php

namespace backend\modules\feedback\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Group
 *
 * @package backend\modules\feedback\models
 */
class Group extends \common\modules\feedback\models\Group implements BaseBackendModel
{

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->joinWith(['lang'])->undeleted()->all(), 'id', 'lang.title');
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
