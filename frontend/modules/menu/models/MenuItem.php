<?php

namespace frontend\modules\menu\models;

use thread\app\model\interfaces\BaseFrontModel;
use yii\helpers\Url;

/**
 * Class MenuItem
 *
 * @package frontend\modules\menu\models
 */
final class MenuItem extends \common\modules\menu\models\MenuItem implements BaseFrontModel
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
        return parent::findBase()->enabled();
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws \Throwable
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()->byAlias($alias)->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()->byId($id)->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param string $group
     * @param int $parent
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAllByGroup($group = '', $parent = 0)
    {
        $result = self::getDb()->cache(function ($db) use ($group, $parent) {
            return self::findBase()->group_id($group)->parent_id($parent)->all();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param bool|false $scheme
     */
    public function getUrl($scheme = false)
    {
        // TODO: Implement getUrl() method.
    }
}
