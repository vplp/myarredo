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
        return parent::findBase()->enabled();
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/specification/view', 'alias' => $this->alias]);
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
        return (new search\Specification())->search($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public static function getAllWithFilter($params = [])
    {
        return self::findBase()
            ->andWhere(['parent_id' => 9])
//            ->innerJoinWith([
//                'product' => [
//
//                ]
//            ])
//            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}