<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\catalog\models\{
    Colors, Sale as SaleModel, SaleLang, SubTypes, Factory
};
use frontend\modules\location\models\{
    Country, City
};
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;

/**
 * Class Sale
 *
 * @package frontend\modules\catalog\models\search
 */
class Sale extends SaleModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'factory_id', 'user_id'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
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
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $keys = Yii::$app->catalogFilter->keys;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => !empty($params['defaultPageSize'])
                    ? $params['defaultPageSize']
                    : $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (isset($params['Sale'])) {
            $params = array_merge($params, $params['Sale']);
        }

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.factory_id' => $this->factory_id,
            self::tableName() . '.user_id' => $this->user_id
        ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere(['IN', Types::tableName() . '.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere(['IN', Specification::tableName() . '.alias', $params[$keys['style']]]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $query->andFilterWhere([self::tableName() . '.currency' => $params[$keys['price']][2]]);
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', self::tableName() . '.price_new', $min, $max]);
        }

        if (isset($params['country'])) {
            $query
                ->innerJoinWith(["country"])
                ->andFilterWhere(['IN', Country::tableName() . '.id', $params['country']]);
        }

        if (isset($params['city'])) {
            $query
                ->innerJoinWith(["city"])
                ->andFilterWhere(['IN', City::tableName() . '.id', $params['city']]);
        }

        $query->andFilterWhere(['like', SaleLang::tableName() . '.title', $this->title]);

        /**
         * cache
         */

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        });

        return $dataProvider;
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = SaleModel::findBase()
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.image_link',
                self::tableName() . '.factory_id',
                self::tableName() . '.price',
                self::tableName() . '.price_new',
                self::tableName() . '.currency',
                self::tableName() . '.position',
                self::tableName() . '.factory_name',
                SaleLang::tableName() . '.title'
            ]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function trash($params)
    {
        $query = SaleModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public static function minPrice($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = SaleModel::findBase();

        $query->andFilterWhere([self::tableName() . '.currency' => Yii::$app->currency->code]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere(['IN', Types::tableName() . '.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere(['IN', Specification::tableName() . '.alias', $params[$keys['style']]]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        if (isset($params['country'])) {
            $query
                ->innerJoinWith(["country"])
                ->andFilterWhere(['IN', Country::tableName() . '.id', $params['country']]);
        }

        if (isset($params['city'])) {
            $query
                ->innerJoinWith(["city"])
                ->andFilterWhere(['IN', City::tableName() . '.id', $params['city']]);
        }

        return $query->min(self::tableName() . '.price_new');
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public static function maxPrice($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = SaleModel::findBase();

        $query->andFilterWhere([self::tableName() . '.currency' => Yii::$app->currency->code]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere(['IN', Category::tableName() . '.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere(['IN', Types::tableName() . '.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere(['IN', Specification::tableName() . '.alias', $params[$keys['style']]]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        if (isset($params['country'])) {
            $query
                ->innerJoinWith(["country"])
                ->andFilterWhere(['IN', Country::tableName() . '.id', $params['country']]);
        }

        if (isset($params['city'])) {
            $query
                ->innerJoinWith(["city"])
                ->andFilterWhere(['IN', City::tableName() . '.id', $params['city']]);
        }

        return $query->max(self::tableName() . '.price_new');
    }
}
