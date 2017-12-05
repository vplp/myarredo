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
    Product as ProductModel,
    Specification
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
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $keys = Yii::$app->catalogFilter->keys;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
        ]);

        $query->andWhere([
            self::tableName() . '.removed' => '0'
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

        $order = [];

        if (isset($params['sort']) && $params['sort'] == 'asc') {
            $order[] = self::tableName() . '.factory_price ASC';
        } else if (isset($params['sort']) && $params['sort'] == 'desc') {
            $order[] = self::tableName() . '.factory_price DESC';
        }
        if (isset($params['object']) && $params['object'] == 'composition') {
            $order[] = self::tableName() . '.is_composition DESC';
        }

        $order[] = self::tableName() . '.position DESC';

        $query->orderBy(implode(',', $order));

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
                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['types']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere(['IN', Types::tableName() . '.alias', $params[$keys['types']]]);
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

        $query->select(ProductModel::tableName() . '.id');

        return $query;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductModel::findBase();
        return $this->baseSearch($query, $params);
    }
}