<?php

namespace frontend\modules\catalog\models;

use frontend\modules\location\models\Country;
use Yii;
use yii\helpers\{
    Url, ArrayHelper
};
use frontend\components\ImageResize;

/**
 * Class Category
 *
 * @package frontend\modules\catalog\models
 */
class Category extends \common\modules\catalog\models\Category
{
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
        return self::find()->innerJoinWith(['lang'])->asArray()->enabled();
    }

    /**
     * @param array $option
     * @return array
     */
    public static function dropDownList($option = [])
    {
        $query = self::findBase();

        if (isset($option['type_id'])) {
            $query->innerJoinWith(["types"])
                ->andFilterWhere([Types::tableName() . '.id' => $option['type_id']]);
        }

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    /**
     * @param $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()
                ->andWhere(
                    [self::tableName() . '.' . Yii::$app->languages->getDomainAlias() => $alias]
                )
                ->one();
        }, 7200);

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findById($id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::findBase()->byId($id)->one();
        }, 7200);

        return $result;
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        return (new search\Category())->search($params);
    }

    /**
     * @param string $alias
     * @param string $route
     * @return string
     */
    public static function getUrl(string $alias, $route = '/catalog/category/list')
    {
        return Url::toRoute([$route, 'filter' => $alias], true);
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $url . '/' . $image_link;
        }

        return $image;
    }

    /**
     * ImageThumb
     *
     * @param string $image_link
     * @return null|string
     */
    public static function getImageThumb($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image_link_path = explode('/', $image_link);

            $img_name = $image_link_path[count($image_link_path) - 1];

            unset($image_link_path[count($image_link_path) - 1]);

            $_image_link = $path . '/' . implode('/', $image_link_path) . '/thumb_' . $img_name;

            if (is_file($_image_link)) {
                $image = $_image_link;
            } else {
                $image = $path . '/' . $image_link;
            }

            // resize
            $ImageResize = new ImageResize();
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $ImageResize->getThumb($image, 100, 100);
        }

        return $image;
    }

    /**
     * @param array $params
     * @param bool $isCountriesFurniture
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getWithProduct($params = [], $isCountriesFurniture = false)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["product.types productTypes"], false)
                ->andFilterWhere([
                    'IN',
                    'productTypes.' . Yii::$app->languages->getDomainAlias(),
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
                    'productSpecification.' . Yii::$app->languages->getDomainAlias(),
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

        if (isset($params[$keys['diameter']])) {
            $min = $params[$keys['diameter']][0];
            $max = $params[$keys['diameter']][1];
            $query
                ->innerJoinWith(["product.specificationValue diameter"], false)
                ->andFilterWhere(['diameter.specification_id' => 42])
                ->andFilterWhere(['BETWEEN', 'diameter.val', $min, $max]);
        }

        if (isset($params[$keys['width']])) {
            $min = $params[$keys['width']][0];
            $max = $params[$keys['width']][1];
            $query
                ->innerJoinWith(["product.specificationValue width"], false)
                ->andFilterWhere(['width.specification_id' => 8])
                ->andFilterWhere(['BETWEEN', 'width.val', $min, $max]);
        }

        if (isset($params[$keys['length']])) {
            $min = $params[$keys['length']][0];
            $max = $params[$keys['length']][1];
            $query
                ->innerJoinWith(["product.specificationValue length"], false)
                ->andFilterWhere(['length.specification_id' => 6])
                ->andFilterWhere(['BETWEEN', 'length.val', $min, $max]);
        }

        if (isset($params[$keys['height']])) {
            $min = $params[$keys['height']][0];
            $max = $params[$keys['height']][1];
            $query
                ->innerJoinWith(["product.specificationValue height"], false)
                ->andFilterWhere(['height.specification_id' => 7])
                ->andFilterWhere(['BETWEEN', 'height.val', $min, $max
                ]);
        }

        if (isset($params[$keys['apportionment']])) {
            $min = $params[$keys['apportionment']][0];
            $max = $params[$keys['apportionment']][1];
            $query
                ->innerJoinWith(["product.specification apportionment"], false)
                ->andFilterWhere(['apportionment.specification_id' => 67])
                ->andFilterWhere(['BETWEEN', 'apportionment.val', $min, $max]);
        }

        if (Yii::$app->request->get('show') == 'in_stock') {
            $query->andWhere([
                Product::tableName() . '.in_stock' => '1'
            ]);
        }

        if ($isCountriesFurniture) {
            $query->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]]);
        }

        if (isset($params[$keys['producing_country']])) {
            $country = Country::findBase()->byAlias($params[$keys['producing_country']])->one();
            if ($country != null) {
                $query->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', $country['id']]);
            }
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->innerJoinWith(["product"], false)
                ->innerJoinWith(["product.lang"], false)
                ->innerJoinWith(["product.factory"], false)
                ->andFilterWhere([
                    Product::tableName() . '.published' => '1',
                    Product::tableName() . '.deleted' => '0',
                    Product::tableName() . '.removed' => '0',
                    Factory::tableName() . '.published' => '1',
                    Factory::tableName() . '.deleted' => '0',
                    //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
                ])
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.alias_en',
                    self::tableName() . '.alias_it',
                    self::tableName() . '.alias_de',
                    self::tableName() . '.alias_he',
                    self::tableName() . '.image_link',
                    self::tableName() . '.image_link2',
                    self::tableName() . '.image_link3',
                    self::tableName() . '.image_link_com',
                    self::tableName() . '.image_link2_com',
                    self::tableName() . '.position',
                    CategoryLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        }, 7200);

        return $result;
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
                ->innerJoinWith(["sale.country saleCountry"], false)
                ->andFilterWhere(['IN', 'saleCountry.id', $params['country']]);
        }

        if (isset($params['city'])) {
            $query
                ->innerJoinWith(["sale.city saleCity"], false)
                ->andFilterWhere(['IN', 'saleCity.id', $params['city']]);
        }

        if (isset($params[$keys['price']])) {
            $query->andFilterWhere([Sale::tableName() . '.currency' => $params[$keys['price']][2]]);
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', Sale::tableName() . '.price_new', $min, $max]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->innerJoinWith(["sale"], false)
                ->andFilterWhere([
                    Sale::tableName() . '.published' => '1',
                    Sale::tableName() . '.deleted' => '0',
                ])
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.alias_en',
                    self::tableName() . '.alias_it',
                    self::tableName() . '.alias_de',
                    self::tableName() . '.alias_he',
                    self::tableName() . '.position',
                    self::tableName() . '.image_link',
                    self::tableName() . '.image_link2',
                    self::tableName() . '.image_link3',
                    self::tableName() . '.image_link_com',
                    self::tableName() . '.image_link2_com',
                    CategoryLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        }, 7200);

        return $result;
    }

    /**
     * @param array $params
     * @param bool $isCountriesFurniture
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getWithItalianProduct($params = [], $isCountriesFurniture = false)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["italianProduct.types italianProductTypes"], false)
                ->andFilterWhere([
                    'IN',
                    'italianProductTypes.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['type']]
                ]);
        }

        if (isset($params[$keys['subtypes']])) {
            $query
                ->innerJoinWith(["italianProduct.subTypes italianProductSubTypes"], false)
                ->andFilterWhere(['IN', 'italianProductSubTypes.alias', $params[$keys['subtypes']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["italianProduct.specification italianProductSpecification"], false)
                ->andFilterWhere([
                    'IN',
                    'italianProductSpecification.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['style']]
                ]);
        }

        if (isset($params[$keys['factory']])) {
            $query
                ->innerJoinWith(["italianProduct.factory italianProductFactory"], false)
                ->andFilterWhere(['IN', 'italianProductFactory.alias', $params[$keys['factory']]]);
        }

        if (isset($params[$keys['colors']])) {
            $query
                ->innerJoinWith(["italianProduct.colors as italianProductColors"], false)
                ->andFilterWhere(['IN', 'italianProductColors.alias', $params[$keys['colors']]]);
        }

        if (isset($params[$keys['price']])) {
            $min = Yii::$app->currency->getReversValue($params[$keys['price']][0], Yii::$app->currency->code, 'EUR');
            $max = Yii::$app->currency->getReversValue($params[$keys['price']][1], Yii::$app->currency->code, 'EUR');
            $query->andFilterWhere(['between', ItalianProduct::tableName() . '.price_new', $min, $max]);
        }

        if ($isCountriesFurniture) {
            $query->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]]);
        } else {
            $query->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', [4]]);
        }

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->innerJoinWith(["italianProduct"], false)
                ->innerJoinWith(["italianProduct.factory"], false)
                ->andFilterWhere([
                    ItalianProduct::tableName() . '.published' => '1',
                    ItalianProduct::tableName() . '.deleted' => '0',
                ])
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.alias_en',
                    self::tableName() . '.alias_it',
                    self::tableName() . '.alias_de',
                    self::tableName() . '.alias_he',
                    self::tableName() . '.position',
                    self::tableName() . '.image_link',
                    self::tableName() . '.image_link2',
                    self::tableName() . '.image_link3',
                    self::tableName() . '.image_link_com',
                    self::tableName() . '.image_link2_com',
                    CategoryLang::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->all();
        }, 7200);

        return $result;
    }
}
