<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\catalog\models\{
    Category,
    Types,
    Factory,
    FactoryProduct as FactoryProductModel,
    Specification
};
use frontend\modules\catalog\Catalog;

/**
 * Class FactoryProduct
 *
 * @property integer $category_id
 *
 * @package frontend\modules\catalog\models\search
 */
class FactoryProduct extends FactoryProductModel
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
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
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
                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere(['IN', Types::tableName() . '.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere(['IN', Specification::tableName() . '.alias', $params[$keys['style']]]);
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
            $query->andFilterWhere(['between', self::tableName() . '.price_from', $params[$keys['price']][0], $params[$keys['price']][1]]);
        }

        $order = [];

        if (isset($params['sort']) && $params['sort'] == 'asc') {
            $order[] = self::tableName() . '.factory_price ASC';
        } else if (isset($params['sort']) && $params['sort'] == 'desc') {
            $order[] = self::tableName() . '.factory_price DESC';
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

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        });

        return $dataProvider;
    }

//    /**
//     * @param $params
//     * @return mixed
//     */
//    public function getSubQuery($params)
//    {
//        $keys = Yii::$app->catalogFilter->keys;
//
//        $query = FactoryProductModel::findBase();
//
//        $query->andWhere([
//            FactoryProductModel::tableName() . '.removed' => '0'
//        ]);
//
//        $query->andFilterWhere([
//            'id' => $this->id,
//        ]);
//
//        if (isset($params[$keys['category']])) {
//            $query
//                ->innerJoinWith(["category"])
//                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
//        }
//
//        if (isset($params[$keys['types']])) {
//            $query
//                ->innerJoinWith(["types"])
//                ->andFilterWhere(['IN', Types::tableName() . '.alias', $params[$keys['types']]]);
//        }
//
//        if (isset($params[$keys['style']])) {
//            $query
//                ->innerJoinWith(["specification"])
//                ->andFilterWhere(['IN', Specification::tableName() . '.alias', $params[$keys['style']]]);
//        }
//
//        if (isset($params[$keys['factory']])) {
//            $query
//                ->innerJoinWith(["factory"])
//                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
//        }
//
//        $query->select(FactoryProductModel::tableName() . '.id');
//
//        return $query;
//    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = FactoryProductModel::findBase();
        return $this->baseSearch($query, $params);
    }
}