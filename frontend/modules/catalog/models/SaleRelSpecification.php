<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class SaleRelSpecification
 *
 * @package frontend\modules\catalog\models
 */
class SaleRelSpecification extends \common\modules\catalog\models\SaleRelSpecification
{
    public $min;

    public $max;

    /**
     * @param array $params
     * @param int $specification_id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getRange($params = [], $specification_id = 42)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::find();

        $query->andWhere([self::tableName() . '.specification_id' => $specification_id]);

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

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["sale.collection saleCollection"], false)
                ->andFilterWhere(['IN', 'saleCollection.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["sale.colors as saleColors"], false)
                ->andFilterWhere(['IN', 'saleColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Sale::tableName() . '.price_from', $min, $max]);
        }

        if (isset($params[$keys['diameter']]) && $specification_id != 42) {
            $min = $params[$keys['diameter']][0];
            $max = $params[$keys['diameter']][1];
            $query
                ->innerJoinWith(["sale.specificationValue diameter"], false)
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere(['BETWEEN', 'diameter.val', $min, $max]);
        }

        if (isset($params[$keys['width']]) && $specification_id != 8) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];
            $query
                ->innerJoinWith(["sale.specificationValue width"], false)
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere(['BETWEEN', 'width.val', $min, $max]);
        }

        if (isset($params[$keys['length']]) && $specification_id != 6) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];
            $query
                ->innerJoinWith(["sale.specificationValue length"], false)
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere(['BETWEEN', 'length.val', $min, $max]);
        }

        if (isset($params[$keys['height']]) && $specification_id != 7) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];
            $query
                ->innerJoinWith(["sale.specificationValue height"], false)
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere(['BETWEEN', 'height.val', $min, $max
                ]);
        }

        if (isset($params[$keys['apportionment']]) && $specification_id != 67) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];
            $query
                ->innerJoinWith(["sale.specificationValue apportionment"], false)
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere(['BETWEEN', 'apportionment.val', $min, $max]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    'max(' . self::tableName() . '.val) as max',
                    'min(' . self::tableName() . '.val) as min'
                ])
                ->asArray()
                ->one();
        }, \Yii::$app->params['cache']['duration']);

        return $result;
    }
}
