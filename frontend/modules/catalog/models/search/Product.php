<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\catalog\models\{
    Category,
    Types,
    SubTypes,
    Factory,
    Product as ProductModel,
    ProductLang,
    Specification,
    Colors
};
use frontend\modules\catalog\Catalog;

/**
 * Class Product
 *
 * @property integer $category_id
 *
 * @package frontend\modules\catalog\models\search
 */
class Product extends ProductModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'factory_id'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['published', 'removed'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     * @throws \Exception
     * @throws \Throwable
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $keys = Yii::$app->catalogFilter->keys;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($params['pagination']) ? $params['pagination'] : [
                'defaultPageSize' => !empty($params['defaultPageSize'])
                    ? $params['defaultPageSize']
                    : $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
        ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
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
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["collection"])
                ->andFilterWhere(['IN', Collection::tableName() . '.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', self::tableName() . '.price_from', $min, $max]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        /**
         * orderBy
         */

        $order = [];

        /**
         * Promotion
         */
        if (!isset($params[$keys['category']])) {
            $order[] = self::tableName() . '.time_promotion_in_catalog DESC';
        } else {
            $order[] = self::tableName() . '.time_promotion_in_category DESC';
        }

        if (isset($params['sort']) && $params['sort'] == 'asc') {
            $order[] = self::tableName() . '.price_from ASC';
        } elseif (isset($params['sort']) && $params['sort'] == 'desc') {
            $order[] = self::tableName() . '.price_from DESC';
        }

        if (isset($params['object']) && $params['object'] == 'composition') {
            $order[] = self::tableName() . '.is_composition DESC';
        }

        if (isset($params['show']) && $params['show'] == 'in_stock') {
            $query->andWhere([
                self::tableName() . '.in_stock' => '1'
            ]);
        }

        $order[] = self::tableName() . '.updated_at DESC';

        $query->orderBy(implode(',', $order));

        /**
         * cache
         */

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 3600);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getSubQuery($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = ProductModel::findBase();

        $query->andWhere([
            ProductModel::tableName() . '.removed' => '0'
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['types']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
                    $params[$keys['types']]
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
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
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
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        $query->select(ProductModel::tableName() . '.id');

        return $query;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = ProductModel::findBase()
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.image_link',
                self::tableName() . '.factory_id',
                self::tableName() . '.removed',
                self::tableName() . '.price_from',
                self::tableName() . '.currency',
                ProductLang::tableName() . '.title',
            ]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public static function minPrice($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = ProductModel::findBaseWithoutLang();

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
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
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["collection"])
                ->andFilterWhere(['IN', Collection::tableName() . '.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query->min(self::tableName() . '.price_from');
        }, 3600);

        return $result;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public static function maxPrice($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = ProductModel::findBaseWithoutLang();

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
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
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["collection"])
                ->andFilterWhere(['IN', Collection::tableName() . '.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query->max(self::tableName() . '.price_from');
        }, 3600);

        return $result;
    }
}
