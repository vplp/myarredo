<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\catalog\models\{
    Sale as SaleModel, SaleLang
};
use frontend\modules\location\models\{
    Country, City
};
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use yii\helpers\Html;

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
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $keys = Yii::$app->catalogFilter->keys;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (isset($params['Sale'])) {
            $params = array_merge($params, $params['Sale']) ;
        }

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id,
        ]);

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
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

        if (isset($params[$keys['price']])) {
            $query->andFilterWhere(['between', self::tableName() . '.price', $params[$keys['price']][0], $params[$keys['price']][1]]);
        }

        if (Yii::$app->city->getCountryId()) {
            $query
                ->innerJoinWith(["country"])
                ->andFilterWhere(['IN', Country::tableName() . '.id', Yii::$app->city->getCountryId()]);
        }

        if (Yii::$app->city->getCityAlias()) {
            $query
                ->innerJoinWith(["city"])
                ->andFilterWhere(['IN', City::tableName() . '.alias', Yii::$app->city->getCityAlias()]);
        }

        $query->andFilterWhere(['like', SaleLang::tableName() . '.title', $this->title]);

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        });

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SaleModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = SaleModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
