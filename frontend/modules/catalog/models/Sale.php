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
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->enabled()->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->enabled()->one();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Sale())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Sale())->trash($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function partnerSearch($params)
    {
        return (new search\Sale())->partnerSearch($params);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if (isset(Yii::$app->controller->factory)) {
            return Url::toRoute([
                '/catalog/template-factory/sale-product',
                'alias' => Yii::$app->controller->factory->alias,
                'product' => $this->alias
            ], true);
        } else {
            return Url::toRoute([
                '/catalog/sale/view',
                'alias' => $this->alias
            ], true);
        }
    }

    /**
     * @return string
     */
    public function getUrlUpdate()
    {
        return Url::toRoute(['/catalog/partner-sale/update', 'id' => $this->id]);
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getSaleUploadPath();
        $url = $module->getSaleUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        }

        return $image;
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImageThumb($image_link  = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getSaleUploadPath();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {

            $image_link_path = explode('/', $image_link);

            $img_name = $image_link_path[count($image_link_path)-1];

            unset($image_link_path[count($image_link_path)-1]);

//            $dir    = $path . '/' . implode('/' ,$image_link_path);
//            $files = scandir($dir);

            $_image_link = $path . '/' . implode('/', $image_link_path) . '/thumb_' . $img_name;

            if (is_file($_image_link)) {
                $image = $_image_link;
            } else {
                $image = $path . '/' . $image_link;
            }

            // resize
            $ImageResize = new ImageResize();
            $image = $ImageResize->getThumb($image, 340, 340);
        }

        return $image;
    }

    /**
     * @return array
     */
    public function getFrontGalleryImage()
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
        }

        $imagesSources = [];

        foreach ($images as $image) {
            if (file_exists($path . '/' . $image)) {
                $imagesSources[] = [
                    'img' => $url . '/' . $image,
                    'thumb' => self::getImageThumb($image)
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
     * @return string
     */
    public function getFactoryTitle()
    {
        $title = !empty($this->factory) ? $this->factory->title : '';
        $title .= ' ' . !empty($this->factory_name) ? $this->factory_name : '';

        return $title;
    }
}