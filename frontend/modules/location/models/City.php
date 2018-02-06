<?php

namespace frontend\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use frontend\modules\catalog\models\Sale;

/**
 * Class City
 *
 * @package frontend\modules\location\models
 */
class City extends \common\modules\location\models\City
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
     * @param int $country_id
     * @return mixed
     */
    public static function dropDownList($country_id = 0)
    {
        $query = self::findBase();

        $query->andFilterWhere(['country_id' => $country_id]);

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    /**
     * @return string
     */
    public function getSubDomainUrl()
    {
        $url = (!in_array($this->id, array(4, 2, 1)))
            ? 'http://' . $this->alias . '.myarredo.' . $this->country->alias
            : 'http://' . 'www.myarredo.' . $this->country->alias;

        return $url;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasMany(Sale::class, ['city_id' => 'id']);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public static function getWithSale($params = [])
    {
        $keys = Yii::$app->catalogFilter->keys;

        if (isset($params[$keys['country']])) {

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

            if (isset($params[$keys['country']])) {
                $query
                    ->innerJoinWith(["country as country"], false)
                    ->andFilterWhere(['IN', 'country.alias', $params[$keys['country']]]);
            }

            return $query
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    CityLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        } else {
            return [];
        }
    }
}