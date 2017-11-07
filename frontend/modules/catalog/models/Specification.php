<?php

namespace frontend\modules\catalog\models;

use yii\helpers\{
    Url, ArrayHelper
};

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
     * @return mixed
     */
    public static function findBaseArray()
    {
        return parent::findBase()->enabled()->asArray();
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return parent::getChildren()
            ->enabled()
            ->innerJoinWith(['lang'])
            ->orderBy(SpecificationLang::tableName() . '.title');
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return parent::getParent()
            ->enabled()
            ->innerJoinWith(['lang'])
            ->orderBy(SpecificationLang::tableName() . '.title');
    }

    /**
     * @return mixed
     */
    public function getChildrenDropDownList()
    {
        return ArrayHelper::map(
            self::getChildren()->enabled()->all(),
            'id',
            'lang.title'
        );
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
        $query = self::findBaseArray();

        $query->andWhere([self::tableName() . '.parent_id' => 9]);

        $query
            ->innerJoinWith(["product"], false)
            ->innerJoinWith(["product.category productCategory"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
            ]);

        if (isset($params['category'])) {
            $query->andFilterWhere(['IN', 'productCategory.alias', $params['category']]);
        }

        if (isset($params['type'])) {
            $query
                ->innerJoinWith(["product.types productTypes"], false)
                ->andFilterWhere(['IN', 'productTypes.alias', $params['type']]);
        }

        if (isset($params['factory'])) {
            $query
                ->innerJoinWith(["product.factory productFactory"], false)
                ->andFilterWhere(['IN', 'productFactory.alias', $params['factory']]);
        }

        return $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                SpecificationLang::tableName() . '.title',
                'count(' . self::tableName() . '.id) as count'
            ])
            ->groupBy(self::tableName() . '.id')
            ->all();
    }
}