<?php

namespace frontend\modules\catalog\models;

use frontend\modules\location\models\Country;
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
            ->innerJoinWith(['product'], false)
            ->innerJoinWith(['product.factory'], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
                //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
                Factory::tableName() . '.show_for_' . Yii::$app->languages->getDomain() => '1',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(['product.category productCategory'], false)
                ->andFilterWhere([
                    'IN',
                    'productCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(['product.types productTypes'], false)
                ->andFilterWhere([
                    'IN',
                    'productTypes.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(['product.subTypes productSubTypes'], false)
                ->andFilterWhere(['IN', 'productSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(['product.specification productSpecification'], false)
                ->andFilterWhere([
                    'IN',
                    'productSpecification.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['producing_country']])) {
            $country = Country::findBase()->byAlias($params[$keys['producing_country']])->one();
            if ($country != null) {
                $query
                    ->innerJoinWith(['product.factory productFactory'], false)
                    ->andFilterWhere(['IN', 'productFactory.producing_country_id', $country['id']]);
            }
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(['product.factory productFactory'], false)
                ->andFilterWhere(['IN', 'productFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['collection']])) {
            $query
                ->innerJoinWith(['product.collection productCollection'], false)
                ->andFilterWhere(['IN', 'productCollection.id', $params[$keys['collection']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(['product.colors as productColors'], false)
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
                ->innerJoinWith(['product.specificationValue diameter'], false)
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere(['BETWEEN', 'diameter.val', $min, $max]);
        }

        if (isset($params[$keys['width']]) && $specification_id != 8) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];
            $query
                ->innerJoinWith(['product.specificationValue width'], false)
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere(['BETWEEN', 'width.val', $min, $max]);
        }

        if (isset($params[$keys['length']]) && $specification_id != 6) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];
            $query
                ->innerJoinWith(['product.specificationValue length'], false)
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere(['BETWEEN', 'length.val', $min, $max]);
        }

        if (isset($params[$keys['height']]) && $specification_id != 7) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];
            $query
                ->innerJoinWith(['product.specificationValue height'], false)
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere(['BETWEEN', 'height.val', $min, $max
                ]);
        }

        if (isset($params[$keys['apportionment']]) && $specification_id != 67) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];
            $query
                ->innerJoinWith(['product.specificationValue apportionment'], false)
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere(['BETWEEN', 'apportionment.val', $min, $max]);
        }

        if (Yii::$app->request->get('show') == 'in_stock') {
            $query->andWhere([
                Product::tableName() . '.in_stock' => '1'
            ]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            $minArrayVal[] = 'MIN(case when ' . self::tableName() . '.val = 0 then 9999 else ' . self::tableName() . '.val end)';
            for ($n = 2; $n <= 10; $n++) {
                $field = "val$n";
                $minArrayVal[] = 'MIN(case when ' . self::tableName() . '.' . $field . ' = 0 then 9999 else ' . self::tableName() . '.' . $field . ' end)';
            }

            $maxArrayVal[] = 'MAX(' . self::tableName() . '.val)';
            for ($n = 2; $n <= 10; $n++) {
                $field = "val$n";
                $maxArrayVal[] = 'MAX(' . self::tableName() . '.' . $field . ')';
            }

            return $query
                ->select([
                    'GREATEST(' . implode(', ', $maxArrayVal) . ') as max',
                    'LEAST(' . implode(', ', $minArrayVal) . ') as min'
                ])
                ->asArray()
                ->one();
        }, 7200);

        return $result;
    }
}
