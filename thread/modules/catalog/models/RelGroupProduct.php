<?php

namespace thread\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class RelGroupProduct
 *
 * @property integer $id
 * @property string $alias
 * @property string $image_link
 *
 * @package thread\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class RelGroupProduct extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return CatalogModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_rel_group_product}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['deleted', 'published'], 'in', 'range' => array_keys(static::statusKeyRange())],
            ['product_id', 'exist', 'targetClass' => ProductCard::class, 'targetAttribute' => 'id'],
            ['group_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['position', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            //'id' => Yii::t('app', 'id'),
            'group_id' => Yii::t('app', 'group_id'),
            'product_id' => Yii::t('app', 'product_id'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'product_id',
                'group_id',
                'position',
                'created_at',
                'updated_at',
                'published',
                'deleted'
            ],
        ];
    }
}