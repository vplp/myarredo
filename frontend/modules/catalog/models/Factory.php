<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};
//
use frontend\components\ImageResize;

/**
 * Class Factory
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
        return parent::findBase()
            ->andFilterWhere([
                self::tableName() . '.show_for_' . Yii::$app->city->getDomain() => '1',
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
        });

        return $result;
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
        });

        return $result;
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Factory())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/factory/view', 'alias' => $alias], true);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogsFiles()
    {
        return $this->hasMany(FactoryCatalogsFiles::class, ['factory_id' => 'id'])
            ->andWhere(['file_type' => 1])->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricesFiles()
    {
        return $this->hasMany(FactoryPricesFiles::class, ['factory_id' => 'id'])
            ->andWhere(['file_type' => 2])->enabled();
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
            $image = $url . '/' . $image_link;
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
            $image = $ImageResize->getThumb($image, 150, 150);
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
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function getWithProduct($params = [])
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

        if (isset($params[$keys['category']])) {
            $query
                ->innerJoinWith(["product.category productCategory"], false)
                ->andFilterWhere(['IN', 'productCategory.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["product.types productTypes"], false)
                ->andFilterWhere(['IN', 'productTypes.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["product.specification productSpecification"], false)
                ->andFilterWhere(['IN', 'productSpecification.alias', $params[$keys['style']]]);
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
        });

        return $result;
    }

    /**
     * @param array $params
     * @return mixed
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
                ->andFilterWhere(['IN', 'saleCategory.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["sale.types saleTypes"], false)
                ->andFilterWhere(['IN', 'saleTypes.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["sale.specification saleSpecification"], false)
                ->andFilterWhere(['IN', 'saleSpecification.alias', $params[$keys['style']]]);
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
     * @param array $params
     * @return mixed
     */
    public static function getWithItalianProduct($params = [])
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
                ->andFilterWhere(['IN', 'italianProductCategory.alias', $params[$keys['category']]]);
        }

        if (isset($params[$keys['type']])) {
            $query
                ->innerJoinWith(["italianProduct.types italianProductTypes"], false)
                ->andFilterWhere(['IN', 'italianProductTypes.alias', $params[$keys['type']]]);
        }

        if (isset($params[$keys['style']])) {
            $query
                ->innerJoinWith(["italianProduct.specification italianProductSpecification"], false)
                ->andFilterWhere(['IN', 'italianProductSpecification.alias', $params[$keys['style']]]);
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
     * @return mixed
     */
    public static function getListLetters()
    {
        return self::findBase()
            ->select([self::tableName() . '.first_letter'])
            ->groupBy(self::tableName() . '.first_letter')
            ->orderBy(self::tableName() . '.first_letter')
            ->all();
    }

    /**
     * @param array $ids
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getFactoryCategory(array $ids)
    {
        $command = Yii::$app->db->createCommand("SELECT
                COUNT(product.id) as count, 
                factory.id AS factory_id,
                category.id AS category_id,
                category.image_link3 as image_link3,
                category.alias AS alias,
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
            ]);

        return $command->queryAll();
    }

    /**
     * @param int $id
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getFactoryTypes(int $id)
    {
        $command = Yii::$app->db->createCommand("SELECT
                COUNT(types.id) as count, 
                types.id, 
                types.alias,
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
            ]);

        return $command->queryAll();
    }

    /**
     * @param int $id
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getFactoryCollection(int $id)
    {
        $command = Yii::$app->db->createCommand("SELECT
                COUNT(collection.id) as count, 
                collection.id,
                collection.title
            FROM
                " . Collection::tableName() . " collection
            INNER JOIN " . Product::tableName() . " product 
                ON (product.collections_id = collection.id) 
                AND (product.published = :published AND product.deleted = :deleted AND product.removed = :removed)
            WHERE
                product.factory_id = :id
            GROUP BY 
                collection.id
            ORDER BY collection.title")
            ->bindValues([
                ':published' => '1',
                ':deleted' => '0',
                ':removed' => '0',
                ':id' => $id,
            ]);

        return $command->queryAll();
    }

    /**
     * @return int
     */
    public function getFactoryTotalCountSale()
    {
        $model = new Sale();

        $keys = Yii::$app->catalogFilter->keys;
        $params = Yii::$app->catalogFilter->params;

        $params[$keys['factory']] = [$this->alias];

        $models = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $params));

        return $models->totalCount > 1 ? $models->totalCount : 0;
    }
}
