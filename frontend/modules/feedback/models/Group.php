<?php

namespace frontend\modules\feedback\models;

use yii\helpers\{
    Url, ArrayHelper
};
//
use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Group
 *
 * @package frontend\modules\feedback\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends \common\modules\feedback\models\Group implements BaseFrontModel
{
    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function find()
    {
        return parent::find()->enabled()->innerJoinWith(['lang'])->orderBy([self::tableName() . '.position' => SORT_ASC]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id);
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return self::findById($id)->one();
    }

    /**
     * @param $alias
     * @return mixed
     */
    public static function getByAlias($alias)
    {
        return self::findByAlias($alias)->one();
    }

    /**
     * @param bool|false $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/feedback/list/index', 'alias' => $this->alias], $scheme);
    }

    /**
     * Backend form dropdown list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'lang.title');
    }
}
