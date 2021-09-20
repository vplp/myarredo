<?php

namespace frontend\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\{
    Sale, Product, ItalianProduct, Factory
};

/**
 * Class Country
 *
 * @package frontend\modules\location\models
 */
class Country extends \common\modules\location\models\Country
{
    public $count;

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
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        $order[] = City::tableName() . '.`id` = 4 DESC';
        $order[] = City::tableName() . '.`id` = 5 DESC';
        $order[] = CityLang::tableName() . '.`title`';

        return $this
            ->hasMany(City::class, ['country_id' => 'id'])
            ->andFilterWhere([
                City::tableName() . '.published' => '1',
                City::tableName() . '.deleted' => '0',
            ])
            ->innerJoinWith(['lang'])
            ->orderBy(implode(',', $order));
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()
                ->joinWith(['cities', 'cities.country citiesCountry'])
                ->byAlias($alias)
                ->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()
                ->byId($id)
                ->joinWith(['cities', 'cities.country citiesCountry'])
                ->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownList($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $data = self::getDb()->cache(function ($db) use ($IDs) {
            $query = self::findBase();

            if ($IDs) {
                $query->byId($IDs);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownListForRegistration($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $data = self::getDb()->cache(function ($db) use ($IDs) {
            $query = self::findBase()->andFilterWhere(['show_for_registration' => '1']);

            if ($IDs) {
                $query->byId($IDs);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownListWithOrders($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $data = self::getDb()->cache(function ($db) use ($IDs) {
            $query = self::findBase()->innerJoinWith(['order'], false);

            if ($IDs) {
                $query->byId($IDs);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param array $params
     * @param bool $isCountriesFurniture
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getWithProduct($params = [], $isCountriesFurniture = false)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["factory"], false)
            ->innerJoinWith(["factory.product"], false)
            ->innerJoinWith(["factory.product.lang"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
            ]);

        if ($isCountriesFurniture) {
            $query->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]]);
        } else {
            $factories = Factory::find()
                ->with(['lang'])
                ->andFilterWhere([
                    //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
                ])
                ->enabled()
                ->indexBy('producing_country_id')
                ->select('producing_country_id, count(producing_country_id) as count')
                ->groupBy('producing_country_id')
                ->andWhere('producing_country_id > 0')
                ->all();

            $ids = [];

            foreach ($factories as $item) {
                $ids[] = $item['producing_country_id'];
            }

            $query->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', $ids]);
        }

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["factory.product.category productCategory"], false)
                ->andFilterWhere([
                    'IN',
                    'productCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["factory.product.types productTypes"], false)
                ->andFilterWhere([
                    'IN',
                    'productTypes.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["factory.product.subTypes productSubTypes"], false)
                ->andFilterWhere(['IN', 'productSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["factory.product.specification productSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    'productSpecification.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory.product.factory productFactory"], false)
                ->andFilterWhere(['IN', 'productFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["factory.product.collection productCollection"], false)
                ->andFilterWhere(['IN', 'productCollection.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["factory.product.colors as productColors"], false)
                ->andFilterWhere(['IN', 'productColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Product::tableName() . '.price_from', $min, $max]);
        }

        if (isset($params[$keys['diameter']])) {
            $min = $params[$keys['diameter']][0];
            $max = $params[$keys['diameter']][1];
            $query
                ->innerJoinWith(["factory.product.specificationValue diameter"], false)
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere(['BETWEEN', 'diameter.val', $min, $max]);
        }

        if (isset($params[$keys['width']])) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];
            $query
                ->innerJoinWith(["factory.product.specificationValue width"], false)
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere(['BETWEEN', 'width.val', $min, $max]);
        }

        if (isset($params[$keys['length']])) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];
            $query
                ->innerJoinWith(["factory.product.specificationValue length"], false)
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere(['BETWEEN', 'length.val', $min, $max]);
        }

        if (isset($params[$keys['height']])) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];
            $query
                ->innerJoinWith(["factory.product.specificationValue height"], false)
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere(['BETWEEN', 'height.val', $min, $max
                ]);
        }

        if (isset($params[$keys['apportionment']])) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];
            $query
                ->innerJoinWith(["factory.product.specificationValue apportionment"], false)
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere(['BETWEEN', 'apportionment.val', $min, $max]);
        }

        if (Yii::$app->request->get('show') == 'in_stock') {
            $query->andWhere([
                Product::tableName() . '.in_stock' => '1'
            ]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    CountryLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getWithSale($params = [])
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["sale"], false)
            ->andFilterWhere([
                Sale::tableName() . '.published' => '1',
                Sale::tableName() . '.deleted' => '0',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["sale.category saleCategory"], false)
                ->andFilterWhere([
                    'IN',
                    'saleCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["sale.types saleTypes"], false)
                ->andFilterWhere([
                    'IN',
                    'saleTypes.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["sale.subTypes saleSubTypes"], false)
                ->andFilterWhere(['IN', 'saleSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["sale.specification saleSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    'saleSpecification.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["sale.factory saleFactory"], false)
                ->andFilterWhere(['IN', 'saleFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["sale.colors as saleColors"], false)
                ->andFilterWhere(['IN', 'saleColors.alias', $params[$keys['colors']]]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    CountryLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param array $params
     * @param bool $isCountriesFurniture
     * @return mixed
     */
    public static function getWithItalianProduct($params = [], $isCountriesFurniture = false)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["factory"], false)
            ->innerJoinWith(["factory.italianProduct"], false)
            ->innerJoinWith(["factory.italianProduct.lang"], false)
            ->andFilterWhere([
                ItalianProduct::tableName() . '.published' => '1',
                ItalianProduct::tableName() . '.deleted' => '0',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["factory.italianProduct.category italianProductCategory"], false)
                ->andFilterWhere([
                    'IN',
                    'italianProductCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }


        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["factory.italianProduct.types italianProductTypes"], false)
                ->andFilterWhere([
                    'IN',
                    'italianProductTypes.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["factory.italianProduct.subTypes italianProductSubTypes"], false)
                ->andFilterWhere(['IN', 'italianProductSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["factory.italianProduct.specification italianProductSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    'italianProductSpecification.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory.italianProduct.factory italianProductFactory"], false)
                ->andFilterWhere(['IN', 'italianProductFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["factory.italianProduct.colors as italianProductColors"], false)
                ->andFilterWhere(['IN', 'italianProductColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', ItalianProduct::tableName() . '.price_new', $min, $max]);
        }

        if ($isCountriesFurniture) {
            $query->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]]);
        } else {
            $query->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', [4]]);
        }

        return $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                CountryLang::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}
