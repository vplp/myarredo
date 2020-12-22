<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\catalog\models\{
    Colors,
    SubTypes,
    ItalianProduct as ItalianProductModel,
    ItalianProductLang
};
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
            self::tableName() . '.user_id' => $this->user_id,
            self::tableName() . '.factory_id' => $this->factory_id,
            self::tableName() . '.status' => $this->status,
        ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([
                    'IN',
                    Category::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["types"])
                ->andFilterWhere([
                    'IN',
                    Types::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
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
                    Specification::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
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
                ->andFilterWhere([
                    'IN',
                    Colors::tableName() . '.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['colors']]
                ]);
        }

        if (isset($params[$keys['diameter']])) {
            $min = $params[$keys['diameter']][0];
            $max = $params[$keys['diameter']][1];
            $query
                ->innerJoinWith(["specificationValue diameter"])
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere(['BETWEEN', 'diameter.val', $min, $max]);
        }

        if (isset($params[$keys['width']])) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];
            $query
                ->innerJoinWith(["specificationValue width"])
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere(['BETWEEN', 'width.val', $min, $max]);
        }

        if (isset($params[$keys['length']])) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];
            $query
                ->innerJoinWith(["specificationValue length"])
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere(['BETWEEN', 'length.val', $min, $max]);
        }

        if (isset($params[$keys['height']])) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];
            $query
                ->innerJoinWith(["specificationValue height"])
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere(['BETWEEN', 'height.val', $min, $max]);
        }

        if (isset($params[$keys['apportionment']])) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];
            $query
                ->innerJoinWith(["specification apportionment"])
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere(['BETWEEN', 'apportionment.val', $min, $max]);
        }

        $query->andFilterWhere(['like', ItalianProductLang::tableName() . '.title', $this->title]);

        /** orderBy */

        if (isset(Yii::$app->partner) && Yii::$app->partner->id) {
            $order['FIELD (' . self::tableName() . '.user_id, ' . Yii::$app->partner->id . ')'] = SORT_DESC;
        }

        if (DOMAIN_TYPE == 'com' && !isset($params[$keys['style']])) {
            $query->innerJoinWith(["specification"]);
            $order['(CASE WHEN ' . Specification::tableName() . '.id = 28 THEN 0 ELSE 9999 END), ' . self::tableName() . '.position'] = SORT_DESC;
        }

        $order[self::tableName() . '.updated_at'] = SORT_DESC;

        $query->orderBy($order);

        /** cache */

        if (Yii::$app->controller->id == 'sale-italy') {
            self::getDb()->cache(function ($db) use ($dataProvider) {
                $dataProvider->prepare();
            }, Yii::$app->params['cache']['duration'], self::generateDependency(self::find()));
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
}
