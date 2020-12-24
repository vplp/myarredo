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
        return parent::findBase()->asArray()->enabled();
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws \Throwable
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()
                ->joinWith(['country', 'country.lang'])
                ->byAlias($alias)
                ->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()
                ->joinWith(['country', 'country.lang'])
                ->byId($id)->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param int $country_id
     * @return array|mixed
     * @throws \Throwable
     */
    public static function dropDownList($country_id = 0)
    {
        $data = self::getDb()->cache(function ($db) use ($country_id) {
            $query = self::findBase();

            if ($country_id) {
                $query->andFilterWhere(['country_id' => $country_id]);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    /**
     * @param $model
     * @return string
     */
    public static function getSubDomainUrl($model)
    {
        $url = (!in_array($model['id'], array(1, 2, 4, 159, 160, 163, 164)))
            ? 'https://' . $model['alias'] . '.myarredo.' . $model['country']['alias']
            : 'https://' . 'www.myarredo.' . $model['country']['alias'];

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

        $query = self::findBase();

        $query
            ->innerJoinWith(["sale"], false)
            ->andFilterWhere([
                Sale::tableName() . '.published' => '1',
                Sale::tableName() . '.deleted' => '0',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["sale.category saleCategory"], false)
                ->andFilterWhere([
                    'IN',
                    'saleCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["sale.types saleTypes"], false)
                ->andFilterWhere([
                    'IN',
                    'saleTypes.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["sale.subTypes saleSubTypes"], false)
                ->andFilterWhere(['IN', 'saleSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["sale.specification saleSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    'saleSpecification.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["sale.factory saleFactory"], false)
                ->andFilterWhere(['IN', 'saleFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["sale.colors as saleColors"], false)
                ->andFilterWhere(['IN', 'saleColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params['country'])) {
            $query
                ->innerJoinWith(["country as country"], false)
                ->andFilterWhere(['IN', 'country.id', $params['country']]);
        }

        if (isset($params[$keys['price']])) {
            $query->andFilterWhere([Sale::tableName() . '.currency' => $params[$keys['price']][2]]);
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Sale::tableName() . '.price_new', $min, $max]);
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
    }
}
