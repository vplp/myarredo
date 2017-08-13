<?php

namespace frontend\modules\catalog\models;

use yii\helpers\Url;

/**
 * Class Types
 *
 * @package frontend\modules\catalog\models
 */
class Types extends \common\modules\catalog\models\Types
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
        return (new search\Types())->search($params);
    }

    /**
     * @param $alias
     * @return string
     */
    public static function getUrl($alias)
    {
        return Url::toRoute(['/catalog/types/view', 'alias' => $alias]);
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
}