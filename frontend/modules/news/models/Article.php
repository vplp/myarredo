<?php

namespace frontend\modules\news\models;

use Yii;
use yii\helpers\Url;
use frontend\components\ImageResize;

/**
 * Class Article
 *
 * @package frontend\modules\news\models
 */
class Article extends \common\modules\news\models\Article
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
            ->orderBy([self::tableName() . '.published_time' => SORT_DESC]);

        $query
            ->innerJoinWith(['cities'])
            ->andFilterWhere([
                'OR',
                [ArticleRelCity::tableName() . '.city_id' => Yii::$app->city->getCityId()],
                [ArticleRelCity::tableName() . '.city_id' => 0]
            ]);

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
     * @param string $group
     * @return mixed
     */
    public static function findByGroupId($group = '')
    {
        return self::findBase()->group_id($group)->all();
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
     * @param bool $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/news/article/index', 'alias' => $this->alias], $scheme);
    }

    /**
     * @param string $image_link
     * @return bool
     */
    public static function isImage($image_link = '')
    {
        $module = Yii::$app->getModule('news');

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
    public static function getImageThumb($image_link = '', $width = 290, $height = 290)
    {
        $module = Yii::$app->getModule('news');

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

    /**
     * @return array
     */
    public function getGalleryImageThumb()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('news');

        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();

        $images = [];

        if (!empty($this->gallery_image)) {
            $this->gallery_image = $this->gallery_image[0] == ','
                ? substr($this->gallery_image, 1)
                : $this->gallery_image;

            $images = explode(',', $this->gallery_image);
        }

        $imagesSources = [];

        foreach ($images as $image) {
            if (is_file($path . '/' . $image)) {
                $imagesSources[] = [
                    'img' => 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $url . '/' . $image,
                    'thumb' => self::getImageThumb($image, 600, 600)
                ];
            } else {
                $imagesSources[] = [
                    'img' => 'https://img.myarredo.ru/' . $url . '/' . $image,
                    'thumb' => 'https://img.myarredo.ru/' . $url . '/' . $image,
                ];
            }
        }

        return $imagesSources;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title))
            ? $this->lang->title
            : "{{-}}";
    }
}
