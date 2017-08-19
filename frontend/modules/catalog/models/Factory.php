<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

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
        return parent::findBase()->enabled()->asArray();
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * Search
     *
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
        return Url::toRoute(['/catalog/factory/view', 'alias' => $alias]);
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage(string $image_link)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();
        $image = null;
        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        } else {
            $image = 'http://placehold.it/200x200';
        }
        return $image;
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        return self::findBase()
            ->all();
    }

    public static function getListLetters()
    {
        return parent::findBase()
            ->enabled()
            ->select([self::tableName() . '.first_letter'])
            ->groupBy(self::tableName() . '.first_letter')
            ->orderBy(self::tableName() . '.first_letter')
            ->all();
    }

    /**
     * Get Factory Categories
     *
     * @param array $ids
     * @return mixed
     */
    public static function getFactoryCategories(array $ids)
    {
        $posts = Yii::$app->db_myarredo->createCommand(
            "SELECT
                factory.id AS factory_id,
                category.id AS category_id,
                category.alias AS alias,
                categoryLang.title AS title
            FROM
                ".self::tableName()." factory
            INNER JOIN ".FactoryLang::tableName()." factoryLang 
                ON (factoryLang.rid = factory.id) AND (factoryLang.lang = :lang)
            INNER JOIN ".Product::tableName()." product 
                ON (product.factory_id = factory.id) 
                AND (product.published = :published AND product.deleted = :deleted)
            INNER JOIN ".ProductRelCategory::tableName()." ProductRelCategory 
                ON (product.id = ProductRelCategory.catalog_item_id)
            INNER JOIN ".Category::tableName()." category 
                ON (category.id = ProductRelCategory.group_id)
            INNER JOIN ".CategoryLang::tableName()." categoryLang 
                ON (categoryLang.rid = category.id) AND (categoryLang.lang = :lang)
            WHERE
                (factory.id IN ('" . implode("','", $ids) . "'))
            GROUP BY 
                category.id , factory.id")
            ->bindValues([
                ':published' =>  '1',
                ':deleted' =>  '0',
                ':lang' =>  Yii::$app->language,
            ])
            ->queryAll();

        return $posts;
    }
}