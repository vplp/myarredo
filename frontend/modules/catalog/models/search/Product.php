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
 * @package frontend\modules\catalog\models\search
 */
class Product extends ProductModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'category', 'factory_id'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
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

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id
        ]);
        //
        $query->innerJoinWith(["category"])->andFilterWhere([ProductRelCategory::tableName() . '.group_id' => $this->category]);

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