<?php

namespace frontend\modules\articles\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Article
 *
 * @package frontend\modules\articles\models
 */
class Article extends \common\modules\articles\models\Article
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
        return parent::findBase()
            ->innerJoinWith(['lang'])
            ->enabled()
            ->orderBy(['published_time' => SORT_DESC]);
    }

    /**
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findLastUpdated()
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBase()
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.updated_at',
                    ArticleLang::tableName() . '.title',
                    ArticleLang::tableName() . '.content'
                ])
                ->orderBy([self::tableName() . '.updated_at' => SORT_DESC])
                ->limit(1)
                ->one();
        });

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()->byId($id)->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()->byAlias($alias)->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/articles/articles/view', 'alias' => $this->alias]);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\Article())->search($params);
    }
}
