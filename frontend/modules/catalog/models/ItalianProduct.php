<?php

namespace frontend\modules\catalog\models;

use frontend\modules\location\models\Currency;
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
            Yii::$app->controller->id == 'italian-product' &&
            Yii::$app->controller->action->id != 'completed' &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $query
                ->andWhere([self::tableName() . '.user_id' => Yii::$app->user->identity->id])
                ->undeleted();
        } elseif (!Yii::$app->getUser()->isGuest &&
            Yii::$app->controller->id == 'italian-product' &&
            Yii::$app->controller->action->id == 'completed' &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $query
                ->andWhere([self::tableName() . '.user_id' => Yii::$app->user->identity->id])
                ->andWhere(['<=', self::tableName() . '.published_date_to', time()])
                ->enabled();
        } else {
            $query
                ->enabled();
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public static function findBaseArray()
    {
        return self::findBase()->asArray();
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
    public function completed($params)
    {
        return (new search\ItalianProduct())->completed($params);
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
            if (is_file($path . '/' . $image)) {
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

    /**
     * @param int $count
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getCostPlacementProduct($count = 1)
    {
        /**
         * cost 1 product = 100 EUR
         * conversion to RUB
         */
        $currency = Currency::findByCode2('EUR');

        $cost = 100 * $currency['course'];

        $amount = $cost + ($cost * 0.02);
        $amount = number_format($amount, 2, '.', '');
        $total = $count * $amount;
        $nds = number_format($amount / 100 * 20, 2, '.', '');

        $discount_percent = 50;
        $discount_money = number_format($total / 100 * $discount_percent, 2, '.', '');

        $amount = number_format($total + $nds - $discount_money, 2, '.', '');

        return [
            'total' => $total,
            'nds' => $nds,
            'discount_percent' => $discount_percent,
            'discount_money' => $discount_money,
            'amount' => $amount,
            'currency' => 'RUB',
        ];
    }

    /**
     * @param $model
     * @return float|int|string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFreeCostPlacementProduct($model)
    {
        /**
         * cost 1 product = 100 EUR
         * conversion to RUB
         */
        $currency = Currency::findByCode2('EUR');

        $cost = ($model['price_new'] / 100) * 22 * $currency['course'];

        $cost = number_format($cost, 2, '.', '');

        return $cost;
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
        return '-' . ceil(($model['price_new'] * 100) / $model['price']) . '%';
    }
}
