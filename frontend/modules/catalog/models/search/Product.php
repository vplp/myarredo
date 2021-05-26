<?php

namespace frontend\modules\catalog\models\search;

use frontend\modules\location\models\Country;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\catalog\models\{
    Category,
    Types,
    SubTypes,
    Factory,
    Product as ProductModel,
    ProductLang,
    Specification,
    Colors,
    ProductRelSpecification
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

        if (isset($params[$keys['producing_country']])) {
            $country = Country::findBase()->byAlias($params[$keys['producing_country']])->one();
            if ($country != null) {
                $query
                    ->innerJoinWith(["factory"])
                    ->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', $country['id']]);
            }
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
                ->andFilterWhere([
                    'IN',
                    Colors::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['colors']]
                ]);
        }

        if (isset($params[$keys['diameter']])) {
            $min = $params[$keys['diameter']][0];
            $max = $params[$keys['diameter']][1];

            //$arr[] = 'OR';
            $arr = ['BETWEEN', 'diameter.val', $min, $max];
//            for ($n = 2; $n <= 10; $n++) {
//                $field = "val$n";
//                $arr[] = ['BETWEEN', 'diameter.' . $field, $min, $max];
//            }

            $query
                ->innerJoinWith(["specificationValue diameter"])
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere($arr);
        }

        if (isset($params[$keys['width']])) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];

            //$arr[] = 'OR';
            $arr = ['BETWEEN', 'width.val', $min, $max];
//            for ($n = 2; $n <= 10; $n++) {
//                $field = "val$n";
//                $arr[] = ['BETWEEN', 'width.' . $field, $min, $max];
//            }

            $query
                ->innerJoinWith(["specificationValue width"])
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere($arr);
        }

        if (isset($params[$keys['length']])) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];

            //$arr[] = 'OR';
            $arr = ['BETWEEN', 'length.val', $min, $max];
//            for ($n = 2; $n <= 10; $n++) {
//                $field = "val$n";
//                $arr[] = ['BETWEEN', 'length.' . $field, $min, $max];
//            }

            $query
                ->innerJoinWith(["specificationValue length"])
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere($arr);
        }

        if (isset($params[$keys['height']])) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];

            //$arr[] = 'OR';
            $arr = ['BETWEEN', 'height.val', $min, $max];
//            for ($n = 2; $n <= 10; $n++) {
//                $field = "val$n";
//                $arr[] = ['BETWEEN', 'height.' . $field, $min, $max];
//            }

            $query
                ->innerJoinWith(["specificationValue height"])
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere($arr);
        }

        if (isset($params[$keys['apportionment']])) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];

            //$arr[] = 'OR';
            $arr = ['BETWEEN', 'apportionment.val', $min, $max];
//            for ($n = 2; $n <= 10; $n++) {
//                $field = "val$n";
//                $arr[] = ['BETWEEN', 'apportionment.' . $field, $min, $max];
//            }

            $query
                ->innerJoinWith(["specification apportionment"])
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere($arr);
        }

        if (isset($params['show']) && $params['show'] == 'in_stock') {
            $query->andWhere([
                self::tableName() . '.in_stock' => '1'
            ]);
        }

        /** orderBy */

        if (!isset($params[$keys['category']])) {
            $order[self::tableName() . '.time_promotion_in_catalog'] = SORT_DESC;
        } else {
            $order[self::tableName() . '.time_promotion_in_category'] = SORT_DESC;
        }

        if (isset($params['sort']) && $params['sort'] == 'asc') {
            $order[self::tableName() . '.price_from'] = SORT_ASC;
        } elseif (isset($params['sort']) && $params['sort'] == 'desc') {
            $order[self::tableName() . '.price_from'] = SORT_DESC;
        } elseif (isset($params['sort']) && $params['sort'] == 'novelty') {
            $order[self::tableName() . '.novelty'] = SORT_DESC;
        }

        if (!isset($params['object'])) {
            $order[self::tableName() . '.is_composition'] = SORT_DESC;
        }

        if (DOMAIN_TYPE == 'com' && !isset($params[$keys['style']])) {
            $query->innerJoinWith(["specification"]);
            $order['(CASE WHEN ' . Specification::tableName() . '.id = 28 THEN 0 ELSE 9999 END), ' . self::tableName() . '.position'] = SORT_ASC;
        }

        $order[self::tableName() . '.updated_at'] = SORT_DESC;

        $query->orderBy($order);

        $query->groupBy(self::tableName() . '.id');

        /** cache */

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 7200, self::generateDependency(self::find()));

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
                    Category::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['types']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Types::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
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
                self::tableName() . '.alias_en',
                self::tableName() . '.alias_it',
                self::tableName() . '.alias_de',
                self::tableName() . '.alias_fr',
                self::tableName() . '.alias_he',
                self::tableName() . '.image_link',
                self::tableName() . '.factory_id',
                self::tableName() . '.bestseller',
                self::tableName() . '.novelty',
                self::tableName() . '.removed',
                self::tableName() . '.price_from',
                self::tableName() . '.currency',
                self::tableName() . '.updated_at',
                ProductLang::tableName() . '.title',
            ]);

        return $this->baseSearch($query, $params);
    }
}
