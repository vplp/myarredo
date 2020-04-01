<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
//
use frontend\modules\catalog\Catalog;
use yii\helpers\Url;

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
     * @param string $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        return Url::toRoute([
            '/catalog/countries-furniture/view',
            'alias' => $alias
        ], true);

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
                'category',
                'category.lang'
            ])
            ->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]])
            ->published()
            ->asArray();

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
            ->published()
            ->asArray();

        $data2 = $query2->all();

        $data = array_merge($data1, $data2);

        /**
         * ArrayDataProvider
         */
        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'defaultPageSize' => !empty($params['defaultPageSize'])
                    ? $params['defaultPageSize']
                    : $module->itemOnPage,
            ],
            'sort' => [
                'attributes' => ['id'],
            ],
        ]);
    }
}
