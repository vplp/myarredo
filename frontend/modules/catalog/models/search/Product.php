<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use frontend\modules\catalog\models\{
    Product as ProductModel,
    ProductRelCategory
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ],
        ]);

        $query->andWhere([
            'removed' => '0'
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        if (isset($params['category'])) {
            $query->innerJoinWith(["category"])
                ->andFilterWhere([ProductRelCategory::tableName() . '.group_id' => $params['category']['id']]);
        }

        if (isset($params['type'])) {
            $query->andFilterWhere(['catalog_type_id' => $params['type']['id']]);
        }

        if (isset($params['factory'])) {
            $query->andFilterWhere(['factory_id' => $params['factory']['id']]);
        }

        if (isset($params['collection'])) {
            $query->andFilterWhere(['collections_id' => $params['collection']['id']]);
        }

        $order = [];

        if (isset($params['sort']) && $params['sort'] == 'asc') {
            $order[] = self::tableName() . '.factory_price ASC';
        } else if (isset($params['sort']) && $params['sort'] == 'desc') {
            $order[] = self::tableName() . '.factory_price DESC';
        } if (isset($params['object']) && $params['object'] == 'composition') {
            $order[] = self::tableName() . '.is_composition DESC';
        }

        $order[] = self::tableName() . '.updated_at DESC';

        $query->orderBy(implode(',', $order));

        return $dataProvider;
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