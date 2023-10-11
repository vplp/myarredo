<?php

namespace thread\modules\page\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector, Url
};
//
use thread\app\base\models\{
    ActiveRecord, query\ActiveQuery
};
use thread\modules\page\Page as PageModule;

/**
 * Class Page
 *
 * @property integer $id
 * @property string $alias
 * @property string $image_link
 * @property integer $published
 * @property integer $deleted
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Lang $lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Page extends ActiveRecord
{
    /**
     * Using db connection
     * @return string
     */
    public static function getDb()
    {
        return PageModule::getDb();
    }

    /**
     * Page table name
     * @return string
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['created_at', 'updated_at'], 'integer'],
            [['alias', 'image_link'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['alias', 'image_link', 'published', 'deleted'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'image_link' => Yii::t('app', 'Image link'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(PageLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(PageLang::class, ['rid' => 'id']);
    }

    /**
     * Url route to view particular page
     *
     * @param null $schema
     * @return string
     */
    public function getUrl($schema = null)
    {
        return Url::toRoute(['/page/page/view', 'alias' => $this->alias], $schema);
    }
}
