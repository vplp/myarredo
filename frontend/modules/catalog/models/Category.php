<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\{
    Url, ArrayHelper
};

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
        return parent::findBase()->enabled()->asArray();
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
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Category())->search($params);
    }

    /**
     * @param string $alias
     * @return string
     */
    public static function getUrl(string $alias)
    {
        return Url::toRoute(['/catalog/category/list', 'filter' => $alias]);
    }

    /**
     * @param string $image_link
     * @return null|string
     */
    public static function getImage(string $image_link  = '')
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getCategoryUploadPath();
        $url = $module->getCategoryUploadUrl();

        $image = null;

        if (!empty($image_link) && is_file($path . '/' . $image_link)) {
            $image = $url . '/' . $image_link;
        }

        return $image;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        $query = self::findBase();

        if (isset($params['type'])) {
            $query
                ->innerJoinWith(["product"], false)
                ->andFilterWhere([
                    Product::tableName() . '.catalog_type_id' => $params['type']['id'],
                    Product::tableName() . '.published' => '1',
                    Product::tableName() . '.deleted' => '0',
                ]);
        }

        if (isset($params['style'])) {
            $query
                ->innerJoinWith(["product"], false)
                ->innerJoinWith(["product.specification productSpecification"], false)
                ->andFilterWhere([
                    ProductRelSpecification::tableName() . '.specification_id' => $params['style']['id'],
                    Product::tableName() . '.published' => '1',
                    Product::tableName() . '.deleted' => '0',
                ]);
        }

        if (isset($params['factory'])) {
            $query
                ->innerJoinWith(["product"], false)
                ->andFilterWhere([
                    Product::tableName() . '.factory_id' => $params['factory']['id'],
                    Product::tableName() . '.published' => '1',
                    Product::tableName() . '.deleted' => '0',
                ]);
        }

        return $query
            ->innerJoinWith(["product"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
            ])
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.position',
                CategoryLang::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}