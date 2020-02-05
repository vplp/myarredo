<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
//
use frontend\components\ImageResize;

/**
 * Class Sale
 *
 * @package frontend\modules\catalog\models
 */
class Sale extends \common\modules\catalog\models\Sale
{
    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (Yii::$app->user->identity->group->role == 'partner') {
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

        if (Yii::$app->controller->id == 'partner-sale') {
            $query
                ->andWhere(['user_id' => Yii::$app->user->identity->id])
                ->undeleted();
        } else {
            $query
                ->enabled();
        }

        /**
         * orderBy
         */

        $order = [];

        $order[] = self::tableName() . '.on_main DESC';

        $partner = Yii::$app->partner->getPartner();
        if ($partner != null && $partner->id) {
            $order[] = '(CASE WHEN ' . self::tableName() . '.user_id=' . $partner->id . ' THEN 0 ELSE 1 END), position DESC';
        }

        $order[] = self::tableName() . '.updated_at DESC';

        $query->orderBy(implode(',', $order));

        return $query;
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
            return self::findBase()
                ->joinWith([
                    'lang',
                    'specificationValue',
                    'specificationValue.specification',
                    'specificationValue.specification.lang'
                ])
                ->byAlias($alias)
                ->one();
        }, 60 * 60);

        return $result;
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
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public static function minPrice($params)
    {
        return search\Sale::minPrice($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public static function maxPrice($params)
    {
        return search\Sale::maxPrice($params);
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\Sale())->search($params);
    }

    /**
     * @param $params
     * @return mixed|\yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function trash($params)
    {
        return (new search\Sale())->trash($params);
    }

    /**
     * @param string $alias
     * @param bool $scheme
     * @return string
     */
    public static function getUrl(string $alias, $scheme = true)
    {
        if (isset(Yii::$app->controller->factory)) {
            return Url::toRoute([
                '/catalog/template-factory/sale-product',
                'alias' => Yii::$app->controller->factory->alias,
                'product' => $alias
            ], $scheme);
        } else {
            return Url::toRoute([
                '/catalog/sale/view',
                'alias' => $alias
            ], $scheme);
        }
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
            $image = 'https://img.myarredo.' . DOMAIN . $url . '/' . $image_link;
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
            $image = 'https://img.myarredo.' . DOMAIN . $ImageResize->getThumb($image, $width, $height);
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

            foreach ($images as $key => $image) {
                if (!is_file($path . '/' . $image)) {
                    unset($images[$key]);
                }
            }
        }

        $images = !empty($images) ? $images : [$this->image_link];

        $imagesSources = [];

        foreach ($images as $image) {
            if (is_file($path . '/' . $image)) {
                $imagesSources[] = [
                    'img' => 'https://img.myarredo.' . DOMAIN . $url . '/' . $image,
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

    /**
     * Static title
     *
     * @param $model
     * @return string
     */
    public static function getStaticTitle($model)
    {
        $title = $model['lang']['title'] ?? '{{-}}';

        return $title;
    }

    /**
     * @return string
     */
    public function getFactoryTitle()
    {
        $title = !empty($this->factory) ? $this->factory->title : '';
        $title .= ' ' . !empty($this->factory_name) ? $this->factory_name : '';

        return $title;
    }

    /**
     * @param $model
     * @return int
     */
    public static function getSavingPrice($model)
    {
        return ($model['price'] > 0)
            ? $model['price'] - $model['price_new']
            : 0;
    }

    /**
     * @param $model
     * @return string
     */
    public static function getSavingPercentage($model)
    {
        return '-' . (100 - ceil(($model['price_new'] * 100) / $model['price'])) . '%';
    }
}
