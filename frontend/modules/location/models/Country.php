<?php

namespace frontend\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use frontend\modules\catalog\models\Sale;

/**
 * Class Country
 *
 * @package frontend\modules\location\models
 */
class Country extends \common\modules\location\models\Country
{
    public $count;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['country_id' => 'id'])
            ->andFilterWhere([
                City::tableName() . '.published' => '1',
                City::tableName() . '.deleted' => '0',
            ])
            ->innerJoinWith(['lang'])
            ->orderBy(CityLang::tableName() . '.title');
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * Drop down list
     *
     * @return mixed
     */
    public static function dropDownList()
    {
        $query = self::findBase();

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasMany(Sale::class, ['country_id' => 'id']);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public static function getWithSale($params = [])
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["sale"], false)
            ->innerJoinWith(["sale.category saleCategory"], false)
            ->andFilterWhere([
                Sale::tableName() . '.published' => '1',
                Sale::tableName() . '.deleted' => '0',
            ]);

        if (isset($params[$keys['category']])) {
            $query->andFilterWhere(['IN', 'saleCategory.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["sale.specification saleSpecification"], false)
                ->andFilterWhere(['IN', 'saleSpecification.alias', $params[$keys['style']]]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["sale.factory saleFactory"], false)
                ->andFilterWhere(['IN', 'saleFactory.alias', $params[$keys['factory']]]);
        }

        return $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                CountryLang::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}