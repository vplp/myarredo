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
        return parent::findBase()->asArray()->enabled();
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
     * @param string $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()
                ->joinWith(['cities', 'cities.country citiesCountry'])
                ->byAlias($alias)
                ->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()
                ->byId($id)
                ->joinWith(['cities', 'cities.country citiesCountry'])
                ->one();
        }, 60 * 60);

        return $result;
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownList($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $data = self::getDb()->cache(function ($db) use ($IDs) {
            $query = self::findBase();

            if ($IDs) {
                $query->byId($IDs);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownListForRegistration($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $data = self::getDb()->cache(function ($db) use ($IDs) {
            $query = self::findBase()->andFilterWhere(['show_for_registration' => '1']);

            if ($IDs) {
                $query->byId($IDs);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param array $IDs
     * @param string $from
     * @param string $to
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function dropDownListWithOrders($IDs = [], $from = 'id', $to = 'lang.title')
    {
        $data = self::getDb()->cache(function ($db) use ($IDs) {
            $query = self::findBase()->innerJoinWith(['order'], false);

            if ($IDs) {
                $query->byId($IDs);
            }

            return $query->all();
        }, 60 * 60);

        return ArrayHelper::map($data, $from, $to);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
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
                    Yii::$app->city->domain != 'com' ? 'saleCategory.alias' : 'saleCategory.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["sale.types saleTypes"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'saleTypes.alias' : 'saleTypes.alias2',
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
                    Yii::$app->city->domain != 'com' ? 'saleSpecification.alias' : 'saleSpecification.alias2',
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

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    CountryLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        }, 60 * 60);

        return $result;
    }
}
