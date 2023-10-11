<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use backend\modules\catalog\Catalog;

/**
 * Class CountriesFurniture
 *
 * @package backend\modules\catalog\models
 */
class CountriesFurniture extends Model
{
    public $title;
    public $producing_country_id;
    public $category;
    public $factory;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['producing_country_id', 'category', 'factory'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'producing_country_id' => Yii::t('app', 'Producing country'),
            'category' => Yii::t('app', 'Category'),
            'factory' => Yii::t('app', 'Factory'),
        ];
    }

    /**
     * @param $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $this->load($params);

        /**
         * Product
         */
        $query1 = Product::findBase();

        $query1
            ->innerJoinWith([
                'factory',
                'factory.producingCountry',
                'factory.producingCountry.lang',
                'category', 'category.lang'
            ])
            ->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]])
            ->undeleted()
            ->asArray();

        $query1->andFilterWhere(['like', ProductLang::tableName() . '.title', $this->title]);
        $query1->andFilterWhere([Factory::tableName() . '.producing_country_id' => $this->producing_country_id]);
        $query1->andFilterWhere([Product::tableName() . '.factory_id' => $this->factory]);
        $query1->andFilterWhere([ProductRelCategory::tableName() . '.group_id' => $this->category]);

        $data1 = $query1->all();

        /**
         * ItalianProduct
         */
        $query2 = ItalianProduct::findBase();

        $query2
            ->innerJoinWith([
                'factory',
                'factory.producingCountry',
                'factory.producingCountry.lang',
                'category',
                'category.lang'
            ])
            ->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]])
            ->undeleted()
            ->asArray();

        $query2->andFilterWhere(['like', ItalianProductLang::tableName() . '.title', $this->title]);
        $query2->andFilterWhere([Factory::tableName() . '.producing_country_id' => $this->producing_country_id]);
        $query1->andFilterWhere([ItalianProduct::tableName() . '.factory_id' => $this->factory]);
        $query1->andFilterWhere([ItalianProductRelCategory::tableName() . '.group_id' => $this->category]);

        $data2 = $query2->all();

        $data = array_merge($data1, $data2);

        /**
         * ArrayDataProvider
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $module->itemOnPage,
            ]
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'producing_country_id'
            ]
        ]);

        return $dataProvider;
    }
}
