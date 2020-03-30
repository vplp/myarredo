<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
//
use backend\modules\catalog\Catalog;

/**
 * Class CountriesFurniture
 *
 * @package backend\modules\catalog\models
 */
class CountriesFurniture extends Model
{
    public $producing_country_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['producing_country_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'producing_country_id' => Yii::t('app', 'Producing country')
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

        $query1->andFilterWhere([Factory::tableName() . '.producing_country_id' => $this->producing_country_id]);

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

        $query2->andFilterWhere([Factory::tableName() . '.producing_country_id' => $this->producing_country_id]);

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
