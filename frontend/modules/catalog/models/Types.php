<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};

/**
 * Class Types
 *
 * @package frontend\modules\catalog\models
 */
class Types extends \common\modules\catalog\models\Types
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
        return parent::findBase()->enabled()->asArray();
    }

    /**
     * @param string $category_alias
     * @return array
     */
    public static function findByCategoryAlias($category_alias)
    {
        $query = self::findBase();

        if ($category_alias != '') {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    Category::tableName() . '.alias' => $category_alias
                ]);
        }

        $data = $query->all();

        return $data;
    }

    /**
     * @return mixed
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->all(), 'id', 'lang.title');
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
            if (is_array($alias)) {
                return self::findBase()
                    ->andWhere([
                        'IN',
                        Yii::$app->city->domain != 'com' ? self::tableName() . '.alias' : self::tableName() . '.alias2',
                        $alias
                    ])
                    ->all();
            } else {
                return self::findBase()
                    ->andWhere(
                        Yii::$app->city->domain != 'com' ? self::tableName() . '.alias = :alias' : self::tableName() . '.alias2 = :alias',
                        [':alias' => $alias]
                    )
                    ->one();
            }
        });

        return $result;
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\Types())->search($params);
    }

    /**
     * @param $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        return Url::toRoute(['/catalog/types/view', 'alias' => $alias], true);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getWithProduct($params = [])
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["product"], false)
            //->innerJoinWith(["product.lang"], false)
            ->innerJoinWith(["product.factory"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                Factory::tableName() . '.show_for_' . Yii::$app->city->getDomain() => '1',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["product.category productCategory"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'productCategory.alias' : 'productCategory.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["product.subTypes productSubTypes"], false)
                ->andFilterWhere(['IN', 'productSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["product.specification productSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'productSpecification.alias' : 'productSpecification.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["product.factory productFactory"], false)
                ->andFilterWhere(['IN', 'productFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["product.collection productCollection"], false)
                ->andFilterWhere(['IN', 'productCollection.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["product.colors as productColors"], false)
                ->andFilterWhere(['IN', 'productColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Product::tableName() . '.price_from', $min, $max]);
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
                    self::tableName() . '.alias2',
                    TypesLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        });

        return $result;
    }

    /**
     * @param array $params
     * @return mixed
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
                    Yii::$app->city->domain != 'com' ? 'saleCategory.alias' : 'saleCategory.alias2',
                    $params[$keys['category']]
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
                    Yii::$app->city->domain != 'com' ? 'saleSpecification.alias' : 'saleSpecification.alias2',
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

        if (isset($params['country'])) {
            $query
                ->innerJoinWith(["sale.country saleCountry"], false)
                ->andFilterWhere(['IN', 'saleCountry.id', $params['country']]);
        }

        if (isset($params['city'])) {
            $query
                ->innerJoinWith(["sale.city saleCity"], false)
                ->andFilterWhere(['IN', 'saleCity.id', $params['city']]);
        }

        if (isset($params[$keys['price']])) {
            $query->andFilterWhere([Sale::tableName() . '.currency' => $params[$keys['price']][2]]);
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Sale::tableName() . '.price_new', $min, $max]);
        }

        return $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.alias2',
                TypesLang::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->all();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public static function getWithItalianProduct($params = [])
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["italianProduct"], false)
            ->andFilterWhere([
                ItalianProduct::tableName() . '.published' => '1',
                ItalianProduct::tableName() . '.deleted' => '0',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["italianProduct.category italianProductCategory"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'italianProductCategory.alias' : 'italianProductCategory.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["italianProduct.subTypes italianProductSubTypes"], false)
                ->andFilterWhere(['IN', 'italianProductSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["italianProduct.specification italianProductSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'italianProductSpecification.alias' : 'italianProductSpecification.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["italianProduct.factory italianProductFactory"], false)
                ->andFilterWhere(['IN', 'italianProductFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["italianProduct.colors as italianProductColors"], false)
                ->andFilterWhere(['IN', 'italianProductColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', ItalianProduct::tableName() . '.price_new', $min, $max]);
        }

        return $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.alias2',
                TypesLang::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}
