<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\catalog\models\{
    Colors,
    SubTypes,
    ItalianProduct as ItalianProductModel,
    ItalianProductLang
};
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;

/**
 * Class ItalianProduct
 *
 * @package frontend\modules\catalog\models\search
 */
class ItalianProduct extends ItalianProductModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'factory_id', 'user_id'], 'integer'],
            [['status'], 'in', 'range' => array_keys(static::statusRange())],
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
                'defaultPageSize' => isset($params['defaultPageSize'])
                    ? $params['defaultPageSize']
                    : $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (isset($params['ItalianProduct'])) {
            $params = array_merge($params, $params['ItalianProduct']);
        }

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.user_id' => $this->user_id
        ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["factory"])
                ->andFilterWhere(['IN', Factory::tableName() . '.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['price']])) {
//            $query->andFilterWhere(['between', self::tableName() . '.price_new', $params[$keys['price']][0], $params[$keys['price']][1]]);
            //$query->andFilterWhere([self::tableName() . '.currency' => $params[$keys['price']][2]]);

            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');

            $query->andFilterWhere(['between', self::tableName() . '.price_new', $min, $max]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["colors"])
                ->andFilterWhere(['IN', Colors::tableName() . '.alias', $params[$keys['colors']]]);
        }

        $query->andFilterWhere(['like', ItalianProductLang::tableName() . '.title', $this->title]);

        if (Yii::$app->controller->id == 'sale-italy') {
            self::getDb()->cache(function ($db) use ($dataProvider) {
                $dataProvider->prepare();
            });
        }

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
        $query = ItalianProductModel::findBase();

        if (Yii::$app->controller->id == 'sale-italy') {
            $query->select([
                self::tableName() . '.*',
                ItalianProductLang::tableName() . '.title',
            ]);
        }

        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function completed($params)
    {
        $query = ItalianProductModel::findBase()
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.image_link',
                self::tableName() . '.factory_id',
                self::tableName() . '.price',
                self::tableName() . '.price_new',
                self::tableName() . '.currency',
                self::tableName() . '.position',
                ItalianProductLang::tableName() . '.title',
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
        $query = ItalianProductModel::findBase()
            ->select([
                self::tableName() . '.*',
                ItalianProductLang::tableName() . '.title',
            ]);

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

        $query = ItalianProductModel::findBase();

        //$query->andFilterWhere([self::tableName() . '.currency' => Yii::$app->currency->code]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
                    $params[$keys['style']]
                ]);
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

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query->min(self::tableName() . '.price_new');
        });

        return $result;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public static function maxPrice($params)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = ItalianProductModel::findBase();

        //$query->andFilterWhere([self::tableName() . '.currency' => Yii::$app->currency->code]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Category::tableName() . '.alias' : Category::tableName() . '.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Types::tableName() . '.alias' : Types::tableName() . '.alias2',
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["subTypes"])
                ->andFilterWhere(['IN', SubTypes::tableName() . '.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["specification"])
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? Specification::tableName() . '.alias' : Specification::tableName() . '.alias2',
                    $params[$keys['style']]
                ]);
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

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query->max(self::tableName() . '.price_new');
        });

        return $result;
    }
}
