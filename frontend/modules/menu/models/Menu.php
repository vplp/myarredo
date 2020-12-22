<?php

namespace frontend\modules\menu\models;

use thread\app\model\interfaces\BaseFrontModel;

/**
 * Class Menu
 *
 * @package frontend\modules\menu\models
 */
final class Menu extends \common\modules\menu\models\Menu implements BaseFrontModel
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
        return parent::findBase()->asArray()->enabled();
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
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findById($id)->one();
        }, \Yii::$app->params['cache']['duration']);

        return $result;
    }

    /**
     * @param $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findByAlias($alias)->one();
        }, \Yii::$app->params['cache']['duration']);

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
