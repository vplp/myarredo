<?php

namespace thread\modules\menu\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector
};
use yii\db\ActiveQuery;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Menu
 *
 * @property integer $id
 * @property string $alias
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $readonly
 *
 * @property MenuLang $lang
 *
 * @package thread\modules\menu\models
 */
class Menu extends ActiveRecord
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return \thread\modules\menu\Menu::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias);
                },
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted', 'readonly'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'backend' => ['alias', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'readonly' => Yii::t('app', 'Readonly'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(MenuLang::class, ['rid' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(MenuItem::class, ['group_id' => 'id']);
    }

    /**
     * @return int|string
     */
    public function getItemsCount()
    {
        return $this->getItems()->count();
    }
}
