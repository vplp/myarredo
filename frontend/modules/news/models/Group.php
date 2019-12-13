<?php

namespace frontend\modules\news\models;

use yii\helpers\Url;

/**
 * Class Group
 *
 * @package frontend\modules\news\models
 */
class Group extends \common\modules\news\models\Group
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->innerJoinWith(['lang']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param bool|false $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/news/list/index', 'alias' => $this->alias], $scheme);
    }

    /**
     * Get list
     * @return mixed
     */
    public static function getList()
    {
        return self::findBase()->all();
    }
}
