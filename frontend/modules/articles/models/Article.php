<?php

namespace frontend\modules\articles\models;

use Yii;
use yii\helpers\Url;
use frontend\components\ImageResize;

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
        $query = parent::findBase()
            ->innerJoinWith(['lang'])
            ->enabled()
            ->orderBy(['published_time' => SORT_DESC]);

        if (Yii::$app->city->getCityId() == 4) {
            $query->andFilterWhere([
                'OR',
                ['city_id' => Yii::$app->city->getCityId()],
                ['city_id' => 0]
            ]);
        } else {
            $query->andFilterWhere(['city_id' => Yii::$app->city->getCityId()]);
        }

        return $query;
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
     * @param bool $schema
     * @return string
     */
    public function getUrl($schema = false)
    {
        return Url::toRoute(['/articles/articles/view', 'alias' => $this->alias], $schema);
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

    /**
     * @param string $image_link
     * @return bool
     */
    public static function isImage($image_link = '')
    {
        $module = Yii::$app->getModule('articles');

        $path = $module->getArticleUploadPath();

        $image = false;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = true;
        }

        return $image;
    }

    /**
     * @param string $image_link
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function getImageThumb($image_link = '', $width = 340, $height = 340)
    {
        $module = Yii::$app->getModule('articles');

        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $thumb = $path . '/thumb_' . $image_link;

            if (is_file($thumb)) {
                $image = $thumb;
            } else {
                $image = $path . '/' . $image_link;
            }

            // resize
            $ImageResize = new ImageResize();
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $ImageResize->getThumb($image, $width, $height);
        }

        return $image;
    }
}
