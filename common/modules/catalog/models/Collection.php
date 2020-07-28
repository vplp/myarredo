<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class Collection
 *
 * @property integer $id
 * @property integer $factory_id
 * @property integer $user_id
 * @property string $title
 * @property integer $year
 * @property string $first_letter
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $moderation
 *
 * @property Product $product
 * @property Factory $factory
 *
 * @package common\modules\catalog\models
 */
class Collection extends ActiveRecord
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_collection}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['factory_id', 'first_letter'], 'required', 'on' => 'backend'],
            [['factory_id', 'user_id', 'year', 'created_at', 'updated_at', 'position'], 'integer'],
            [['published', 'deleted', 'moderation'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['first_letter'], 'string', 'max' => 1],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->first_letter = mb_strtoupper(mb_substr(trim($this->title), 0, 1, 'UTF-8'), 'UTF-8');

        return parent::beforeValidate();
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
                'year',
                'factory_id',
                'user_id',
                'title',
                'first_letter',
                'published',
                'deleted',
                'moderation'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'factory_id' => Yii::t('app', 'Factory'),
            'user_id' => Yii::t('app', 'User'),
            'title' => Yii::t('app', 'Title'),
            'year' => Yii::t('app', 'Year of creation'),
            'first_letter',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'moderation'
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::class, ['collections_id' => 'id']);
    }
}
