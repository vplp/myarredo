<?php

namespace frontend\modules\catalog\models;

use frontend\modules\location\models\Country;
use Yii;
use yii\helpers\{
    Url, ArrayHelper
};
//
use frontend\components\ImageResize;

/**
 * Class Factory
 *
 * @property CatalogsFiles[] $catalogsFiles
 * @property PricesFiles[] $pricesFiles
 *
 * @package frontend\modules\catalog\models
 */
class Factory extends \common\modules\catalog\models\Factory
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
        return parent::findBase()
            ->andFilterWhere([
                //self::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
            ])
            ->enabled();
    }

    /**
     * @return mixed
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->asArray()->all(), 'id', 'title');
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
            return self::findBase()->byAlias($alias)->one();
        }, 7200);

        return $result;
    }

    /**
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findLastUpdated()
    {
        $result = self::getDb()->cache(function ($db) {
            return self::findBase()
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.title',
                    self::tableName() . '.updated_at',
                    FactoryLang::tableName() . '.content'
                ])
                ->orderBy([self::tableName() . '.updated_at' => SORT_DESC])
                ->limit(1)
                ->one();
        });

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
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findAllByAlias($alias)
    {
        $result = self::getDb()->cache(function ($db) use ($alias) {
            return self::findBase()
                ->andFilterWhere(['IN', self::tableName() . '.alias', $alias])
                ->all();
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
        return (new search\Factory())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        return Url::toRoute(['/catalog/factory/view', 'alias' => $alias], true);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogsFiles()
    {
        return $this->hasMany(FactoryCatalogsFiles::class, ['factory_id' => 'id'])
            ->andWhere([FactoryCatalogsFiles::tableName() . '.file_type' => 1])->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricesFiles()
    {
        return $this->hasMany(FactoryPricesFiles::class, ['factory_id' => 'id'])
            ->andWhere([FactoryPricesFiles::tableName() . '.file_type' => 2])->enabled();
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryUploadPath();
        $url = $module->getFactoryUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $url . '/' . $image_link;
        }

        return $image;
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImageThumb($image_link = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getFactoryUploadPath();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $path . '/' . $image_link;

            // resize
            $ImageResize = new ImageResize();
            $image = 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $ImageResize->getThumb($image, 150, 150);
        }

        return $image;
    }

    public function getVideo()
    {
        if ($this->video) {
            return '<iframe width="560" height="315" src="' . $this->video . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        } else {
            return false;
        }
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

        $query
            ->innerJoinWith(["product"], false)
            ->innerJoinWith(["product.lang"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
                Product::tableName() . '.removed' => '0',
            ]);

        if ($isCountriesFurniture) {
            $query->andFilterWhere(['NOT IN', Factory::tableName() . '.producing_country_id', [4]]);
        }

        if (isset($params[$keys['producing_country']])) {
            $country = Country::findBase()->byAlias($params[$keys['producing_country']])->one();
            if ($country != null) {
                $query->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', $country['id']]);
            }
        }

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["product.category productCategory"], false)
                ->andFilterWhere([
                    'IN',
                    'productCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

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

        $result = self::getDb()->cache(function ($db) use ($query) {
            return $query
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.first_letter',
                    self::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->asArray()
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
                ->select([
                    self::tableName() . '.id',
                    self::tableName() . '.alias',
                    self::tableName() . '.first_letter',
                    self::tableName() . '.title',
                    'count(' . self::tableName() . '.id) as count'
                ])
                ->groupBy(self::tableName() . '.id')
                ->asArray()
                ->all();
        }, 7200);

        return $result;
    }

    /**
     * @param array $params
     * @param bool $isCountriesFurniture
     * @return mixed
     */
    public static function getWithItalianProduct($params = [], $isCountriesFurniture = false)
    {
        $keys = Yii::$app->catalogFilter->keys;

        $query = self::findBase();

        $query
            ->innerJoinWith(["italianProduct"], false)
            ->andFilterWhere([
                ItalianProduct::tableName() . '.published' => '1',
                ItalianProduct::tableName() . '.deleted' => '0',
            ]);

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["italianProduct.category italianProductCategory"], false)
                ->andFilterWhere([
                    'IN',
                    'italianProductCategory.' . Yii::$app->languages->getDomainAlias(),
                    $params[$keys['category']]
                ]);
        }

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

        return $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.first_letter',
                self::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->asArray()
            ->all();
    }

    /**
     * @param array $producing_country_id
     * @return mixed
     */
    public static function getListLetters($producing_country_id = [4])
    {
        return self::findBase()
            ->select([self::tableName() . '.first_letter'])
            ->groupBy(self::tableName() . '.first_letter')
            ->orderBy(self::tableName() . '.first_letter')
            ->andFilterWhere(['IN', self::tableName() . '.producing_country_id', $producing_country_id])
            ->all();
    }

    /**
     * @param array $ids
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFactoryCategory(array $ids)
    {
        $result = self::getDb()->cache(function ($db) use ($ids) {
            return self::getDb()->createCommand("SELECT
                COUNT(product.id) as count, 
                factory.id AS factory_id,
                category.id AS category_id,
                category.image_link3 as image_link3,
                category.alias AS alias,
                category.alias_en AS alias_en,
                category.alias_it AS alias_it,
                category.alias_de AS alias_de,
                category.alias_he AS alias_he,
                categoryLang.title AS title
            FROM
                " . self::tableName() . " factory
            INNER JOIN " . Product::tableName() . " product 
                ON (product.factory_id = factory.id) 
                AND (product.published = :published AND product.deleted = :deleted AND product.removed = :removed)
            INNER JOIN " . ProductRelCategory::tableName() . " ProductRelCategory 
                ON (product.id = ProductRelCategory.catalog_item_id)
            INNER JOIN " . Category::tableName() . " category 
                ON (category.id = ProductRelCategory.group_id)
            INNER JOIN " . CategoryLang::tableName() . " categoryLang 
                ON (categoryLang.rid = category.id) AND (categoryLang.lang = :lang)
            WHERE
                (factory.id IN ('" . implode("','", $ids) . "'))
            GROUP BY 
                category.id , factory.id
            ORDER BY categoryLang.title")
                ->bindValues([
                    ':published' => '1',
                    ':deleted' => '0',
                    ':removed' => '0',
                    ':lang' => Yii::$app->language,
                ])->queryAll();
        }, 7200);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFactoryTypes(int $id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::getDb()->createCommand("SELECT
                COUNT(types.id) as count, 
                types.id, 
                types.alias,
                types.alias_en,
                types.alias_it,
                types.alias_de,
                types.alias_he,
                typesLang.title AS title
            FROM
                " . Types::tableName() . " types
            INNER JOIN " . TypesLang::tableName() . " typesLang 
                ON (typesLang.rid = types.id) AND (typesLang.lang = :lang)
            INNER JOIN " . Product::tableName() . " product 
                ON (product.catalog_type_id = types.id) 
                AND (product.published = :published AND product.deleted = :deleted AND product.removed = :removed)
            WHERE
                product.factory_id = :id
            GROUP BY 
                types.id
            ORDER BY typesLang.title")
                ->bindValues([
                    ':published' => '1',
                    ':deleted' => '0',
                    ':removed' => '0',
                    ':id' => $id,
                    ':lang' => Yii::$app->language,
                ])->queryAll();
        }, 7200);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getFactoryCollection(int $id)
    {
        $result = self::getDb()->cache(function ($db) use ($id) {
            return self::getDb()->createCommand("SELECT
                COUNT(collection.id) as count, 
                collection.id,
                collection.title,
                collection.year
            FROM
                " . Collection::tableName() . " collection
            INNER JOIN " . Product::tableName() . " product 
                ON (product.collections_id = collection.id) 
                AND (product.published = :published AND product.deleted = :deleted AND product.removed = :removed)              
            WHERE
                product.factory_id = :id AND (collection.published = :published AND collection.deleted = :deleted)
            GROUP BY 
                collection.id
            ORDER BY collection.title")
                ->bindValues([
                    ':published' => '1',
                    ':deleted' => '0',
                    ':removed' => '0',
                    ':id' => $id,
                ])->queryAll();
        }, 7200);

        return $result;
    }

    /**
     * @param int $id
     * @return array
     */
    public static function getFactoryArticles(int $id)
    {
        return Product::findBase()
            ->andFilterWhere([
                Product::tableName() . '.factory_id' => $id,
            ])
            ->all();
    }

    /**
     * @param int $id
     * @return array
     */
    public static function getFactorySamples(int $id)
    {
        return Samples::findBase()
            ->andFilterWhere([
                Samples::tableName() . '.factory_id' => $id,
            ])
            ->all();
    }

    /**
     * @return int
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactoryTotalCountSale()
    {
        $model = new Sale();

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $params[$keys['factory']] = [$this->alias];

        $params['country'] = Yii::$app->city->getCountryId();
        $params['city'] = Yii::$app->city->getCityId();

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        return $models->totalCount >= 1 ? $models->totalCount : 0;
    }
}
