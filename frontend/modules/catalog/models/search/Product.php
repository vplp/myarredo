<?php

namespace  frontend\modules\catalog\models\search;

use Yii;
//
use yii\helpers\ArrayHelper;
//
use yii\data\ActiveDataProvider;
//
use yii\base\Model;
//
use frontend\modules\catalog\models\RelGroupProduct;
//
use frontend\modules\catalog\Catalog as CatalogModule;
//
use frontend\modules\catalog\models\{
    Product as ProductModel, ProductLang
};

/**
 * Class Product
 *
 * @property integer $group_id
 *
 * @package backend\modules\catalog\models\search
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class Product extends ProductModel
{
    public $title;
    public $group_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
            [['group_id'], 'integer'],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var CatalogModule $module */
        $module = Yii::$app->getModule('catalog');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ]
        ]);

        /* !!!
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        */

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', ProductLang::tableName() . '.title', $this->title]);

        // add group
        $groupProduct = ArrayHelper::getColumn(RelGroupProduct::find()->andFilterWhere(['group_id' => $params['group_id']])->all(), 'product_id');

        $query->andWhere(['id' => $groupProduct]);

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