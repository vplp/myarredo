<?php

namespace frontend\modules\catalog\models;

use yii\helpers\Url;

/**
 * Class Specification
 *
 * @package frontend\modules\catalog\models
 */
class Specification extends \common\modules\catalog\models\Specification
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
     * @return int|string
     */
//    public function getProductCount()
//    {
//        return $this->getProduct()
//            ->innerJoinWith('lang')
//            ->andWhere(['is_composition' => '0'])
//            ->enabled()
//            ->count();
//    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Specification())->search($params);
    }

    /**
     * @param $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        return Url::toRoute(['/catalog/specification/view', 'alias' => $alias]);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        return self::findBase()
            ->andWhere([self::tableName() . '.parent_id' => 9])
            ->all();
    }
}