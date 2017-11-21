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
        return Url::toRoute(['/catalog/sale/view', 'alias' => $this->alias]);
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
        $url = $module->getSaleUploadUrl();

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
            $ImageResize = new ImageResize($path, $url);
            $image = $ImageResize->getThumb($image, 340, 340);
        }

        return $image;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        $title = (($this->catalog_type_id > 0 && !empty($this->types)) ? $this->types->lang->title . ' ' : '');
        $title .= $this->getFactoryTitle();

        return $title;
    }

    /**
     * @return string
     */
    public function getFactoryTitle()
    {
        $title = !empty($this->factory->lang) ? $this->factory->lang->title : '';
        $title .= ' ' . !empty($this->factory_name) ? $this->factory_name : '';

        return $title;
    }
}