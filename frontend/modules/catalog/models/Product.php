<?php

namespace frontend\modules\catalog\models;

use yii\helpers\Url;

/**
 * Class Product
 *
 * @package frontend\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Product extends \common\modules\catalog\models\Product
{
    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/product/index', 'alias' => $this->alias]);
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(["lang"])->enabled()->orderBy(['id' => SORT_DESC]);
    }

    /**
     *
     * @param integer $id
     * @return ActiveRecord|null
     */
    public static function findById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     *
     * @param integer $group
     * @return ActiveRecord|null
     */
    public static function findByGroupId($group = '')
    {
        return self::findBase()->group_id($group)->all();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * Категориии
     * @return $this
     */
    public function getRelGroupProduct()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])
            ->viaTable(RelGroupProduct::tableName(), ['product_id' => 'id'])->enabled()->innerJoinWith('lang');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Product())->search($params);
    }
}
