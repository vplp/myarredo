<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class ProductRelSpecification
 *
 * @package frontend\modules\catalog\models
 */
class ProductRelSpecification extends \common\modules\catalog\models\ProductRelSpecification
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
            ->innerJoinWith(["product"], false)
            ->innerJoinWith(["product.lang"], false)
            ->innerJoinWith(["product.factory"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                Factory::tableName() . '.show_for_' . Yii::$app->city->getDomain() => '1',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["product.category productCategory"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'productCategory.alias' : 'productCategory.alias2',
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["product.types productTypes"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'productTypes.alias' : 'productTypes.alias2',
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["product.subTypes productSubTypes"], false)
                ->andFilterWhere(['IN', 'productSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["product.specification productSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    Yii::$app->city->domain != 'com' ? 'productSpecification.alias' : 'productSpecification.alias2',
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["product.factory productFactory"], false)
                ->andFilterWhere(['IN', 'productFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(["product.collection productCollection"], false)
                ->andFilterWhere(['IN', 'productCollection.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["product.colors as productColors"], false)
                ->andFilterWhere(['IN', 'productColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Product::tableName() . '.price_from', $min, $max]);
        }

        if (isset($params[$keys['diameter']]) && $specification_id != 42) {
            $min = $params[$keys['diameter']][0];
            $max = $params[$keys['diameter']][1];
            $query
                ->innerJoinWith(["product.specificationValue diameter"], false)
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere(['BETWEEN', 'diameter.val', $min, $max]);
        }

        if (isset($params[$keys['width']]) && $specification_id != 8) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];
            $query
                ->innerJoinWith(["product.specificationValue width"], false)
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere(['BETWEEN', 'width.val', $min, $max]);
        }

        if (isset($params[$keys['length']]) && $specification_id != 6) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];
            $query
                ->innerJoinWith(["product.specificationValue length"], false)
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere(['BETWEEN', 'length.val', $min, $max]);
        }

        if (isset($params[$keys['height']]) && $specification_id != 7) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];
            $query
                ->innerJoinWith(["product.specificationValue height"], false)
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere(['BETWEEN', 'height.val', $min, $max
                ]);
        }

        if (isset($params[$keys['apportionment']]) && $specification_id != 67) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];
            $query
                ->innerJoinWith(["product.specificationValue apportionment"], false)
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere(['BETWEEN', 'apportionment.val', $min, $max]);
        }

        if (Yii::$app->request->get('show') == 'in_stock') {
            $query->andWhere([
                Product::tableName() . '.in_stock' => '1'
            ]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    'max(' . self::tableName() . '.val) as max',
                    'min(' . self::tableName() . '.val) as min'
                ])
                ->asArray()
                ->one();
        }, 60 * 60);

        return $result;
    }
}
