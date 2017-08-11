<?php

namespace frontend\modules\catalog\models;

use yii\helpers\Url;

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
        return parent::findBase()->enabled();
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
     *
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/category/list', 'alias' => $this->alias]);
    }

    /**
     * @return int|string
     */
    public function getProductCount()
    {
        return $this->getProduct()
            ->innerJoinWith('lang')
            ->andWhere(['is_composition' => '0'])
            ->enabled()
            ->count();
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
     * @param $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        return self::findBase()
//            ->innerJoinWith([
//                'product' => [
//
//                ]
//            ])
//            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}