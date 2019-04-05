<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
//
use frontend\components\ImageResize;

/**
 * Class ItalianProduct
 *
 * @package frontend\modules\catalog\models
 */
class ItalianProduct extends \common\modules\catalog\models\ItalianProduct
{
    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (!Yii::$app->getUser()->isGuest &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $this->user_id = Yii::$app->getUser()->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        $query = parent::findBase();

        if (!Yii::$app->getUser()->isGuest &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $query
                ->andWhere(['user_id' => Yii::$app->user->identity->id])
                ->undeleted();
        } else {
            $query
                ->enabled();
        }

        return $query;
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\ItalianProduct())->search($params);
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function trash($params)
    {
        return (new search\ItalianProduct())->trash($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        return Url::toRoute([
            '/catalog/sale-italy/view',
            'alias' => $alias
        ], true);
    }

    /**
     * @param $alias
     * @return bool
     */
    public static function isPublished($alias)
    {
        if (self::findByAlias($alias) != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $image_link
     * @return bool
     */
    public static function isImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();

        $image = false;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = true;
        }

        return $image;
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        }

        return $image;
    }

    /**
     * @param string $image_link
     * @param int $width
     * @param int $height
     * @return null|string
     */
    public static function getImageThumb($image_link = '', $width = 340, $height = 340)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image_link_path = explode('/', $image_link);

            $img_name = $image_link_path[count($image_link_path) - 1];

            unset($image_link_path[count($image_link_path) - 1]);

            $_image_link = $path . '/' . implode('/', $image_link_path) . '/thumb_' . $img_name;

            if (is_file($_image_link)) {
                $image = $_image_link;
            } else {
                $image = $path . '/' . $image_link;
            }

            // resize
            $ImageResize = new ImageResize();
            $image = $ImageResize->getThumb($image, $width, $height);
        }

        return $image;
    }

    /**
     * @return array
     */
    public function getGalleryImageThumb()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getProductUploadPath();
        $url = $module->getProductUploadUrl();

        $images = [];

        if (!empty($this->gallery_image)) {
            $this->gallery_image = $this->gallery_image[0] == ','
                ? substr($this->gallery_image, 1)
                : $this->gallery_image;

            $images = explode(',', $this->gallery_image);
        } else {
            $images[] = $this->image_link;
        }

        $imagesSources = [];

        foreach ($images as $image) {
            if (file_exists($path . '/' . $image)) {
                $imagesSources[] = [
                    'img' => $url . '/' . $image,
                    'thumb' => self::getImageThumb($image, 600, 600)
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
        return (isset($this->lang->title)) ? $this->lang->title : "{{-}}";
    }
}
