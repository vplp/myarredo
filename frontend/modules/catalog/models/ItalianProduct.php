<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;
use frontend\components\ImageResize;
use frontend\modules\location\models\Currency;

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
        if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
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
            Yii::$app->controller->id == 'italian-product-grezzo' &&
            in_array(Yii::$app->user->identity->group->role, ['factory'])) {
            $query
                ->andWhere([self::tableName() . '.user_id' => Yii::$app->user->identity->id])
                ->andWhere([self::tableName() . '.isGrezzo' => '1'])
                ->undeleted();
        } elseif (!Yii::$app->getUser()->isGuest &&
            Yii::$app->controller->id == 'italian-product' &&
            Yii::$app->controller->action->id != 'completed' &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $query
                ->andWhere([self::tableName() . '.user_id' => Yii::$app->user->identity->id])
                ->andWhere([self::tableName() . '.isGrezzo' => '0'])
                ->undeleted();
        } elseif (!Yii::$app->getUser()->isGuest &&
            Yii::$app->controller->id == 'italian-product' &&
            Yii::$app->controller->action->id == 'completed' &&
            in_array(Yii::$app->user->identity->group->role, ['factory', 'partner'])) {
            $query
                ->andWhere([self::tableName() . '.user_id' => Yii::$app->user->identity->id])
                ->andWhere([self::tableName() . '.isGrezzo' => '0'])
                ->andWhere(['<=', self::tableName() . '.published_date_to', time()])
                ->enabled();
        } else {
            $query
                ->andWhere([self::tableName() . '.isGrezzo' => '0'])
                ->enabled();
        }

        return $query;
    }

    /**
     * @param $factory_id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getGrezzo($factory_id)
    {
        return parent::findBase()
            ->andWhere([self::tableName() . '.isGrezzo' => '1'])
            ->andWhere([self::tableName() . '.factory_id' => $factory_id])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id'])
            ->innerJoinWith(["product"], false)
            ->andWhere([Product::tableName() . '.factory_id' => 'factory_id'])
            ->cache(\Yii::$app->params['cache']['duration']);
    }

    /**
     * @return mixed
     */
    public static function findBaseArray()
    {
        return self::findBase()->asArray();
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
                    ItalianProductLang::tableName() . '.title',
                    ItalianProductLang::tableName() . '.description'
                ])
                ->orderBy([self::tableName() . '.updated_at' => SORT_DESC])
                ->limit(1)
                ->one();
        }, \Yii::$app->params['cache']['duration']);

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
            return self::findBase()
                ->joinWith([
                    'lang',
                    'specificationValue',
                    'specificationValue.specification',
                    'specificationValue.specification.lang'
                ])
                ->andWhere([self::tableName() . '.' . Yii::$app->languages->getDomainAlias() => $alias])
                //->byAlias($alias)
                ->one();
        }, \Yii::$app->params['cache']['duration']);

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
     * @param $alias
     * @param bool $scheme
     * @return string
     */
    public static function getUrl($alias, $scheme = true)
    {
        return Url::toRoute([
            '/catalog/sale-italy/view',
            'alias' => $alias
        ], $scheme);
    }

    /**
     * @param $alias
     * @return bool
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
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
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $url . '/' . $image_link;
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
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $ImageResize->getThumb($image, $width, $height);
        } else {
            $image = 'https://img.myarredo.ru/uploads/images/' . $image_link;
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

    /**
     * @return string
     */
    public function getTitleForList()
    {
        return (isset($this->lang->title_for_list))
            ? $this->lang->title_for_list
            : self::getTitle();
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
     * @param int $count
     * @param $isGrezzo
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getCostPlacementProduct($count = 1, $isGrezzo = false)
    {
        if (isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 2) {
            $cost = 1000;
            $amount = $cost;
        } elseif ($isGrezzo) {
            /**
             * cost 1 product = 30 EUR
             * conversion to RUB
             */
            $currency = Currency::findByCode2('EUR');
            $cost = 30 * $currency['course'];
            $amount = $cost + ($cost * 0.02);
        } else {
            /**
             * cost 1 product = 100 EUR
             * conversion to RUB
             */
            $currency = Currency::findByCode2('EUR');
            $cost = 100 * $currency['course'];
            $amount = $cost + ($cost * 0.02);
        }

        $amount = number_format($amount, 2, '.', '');
        $total = $count * $amount;

        $nds = number_format($total / 100 * 20, 2, '.', '');

        $discount_percent = 0;
        $discount_money = number_format(($total + $nds) / 100 * $discount_percent, 2, '.', '');

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
     * @param bool $isGrezzo
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFreeCostPlacementProduct($model, $isGrezzo = false)
    {
        $currency = Currency::findByCode2($model['currency']);
        if ($isGrezzo) {
            /**
             * cost 1 product = 30 EUR
             * conversion to RUB
             */
            $cost = ($model['price_new'] / 30) * 22 * $currency['course'];
        } else {
            /**
             * cost 1 product = 100 EUR
             * conversion to RUB
             */
            $cost = ($model['price_new'] / 100) * 22 * $currency['course'];
        }

        $amount = number_format($cost, 2, '.', '');

        return [
            'amount' => $amount,
            'currency' => $model['currency'],
        ];
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

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public static function getPriceRange($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Category::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Types::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere([
                    'IN',
                    Specification::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.' . Yii::$app->languages->getDomainAlias(), $params[$keys['colors']]]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.factory_id',
                    self::tableName() . '.catalog_type_id',
                    'max(' . self::tableName() . '.price_new) as max',
                    'min(' . self::tableName() . '.price_new) as min'
                ])
                ->asArray()
                ->one();
        }, \Yii::$app->params['cache']['duration']);

        return $result;
    }
}
