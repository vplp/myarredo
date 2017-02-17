<?php

namespace frontend\modules\catalog\models;

use Yii;
//
use yii\helpers\Url;

/**
 * Class Group
 *
 * @package frontend\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Group extends \common\modules\catalog\models\Group
{
    /**
     * @var
     */
    public $articles;

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
     * @return yii\db\ActiveQuery
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * Get by alias
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/group/index', 'alias' => $this->alias]);
    }

    /**
     * Get by parentId
     * @param int $parentId
     * @return ActiveRecord|null
     */
    public static function findByParentId($parentId)
    {
        return self::findBase()->andWhere(['parent_id' => $parentId])->all();
    }

    /**
     * Get children model
     *
     * @return mixed
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])->enabled();
    }

    /**
     * Get parent model
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id'])->enabled();
    }
}