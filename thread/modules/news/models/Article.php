<?php

namespace thread\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\behaviors\AttributeBehavior;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\news\News as NewsModule;

/**
 * Class Article
 *
 * @property integer id
 * @property integer group_id
 * @property string alias
 * @property string image_link
 * @property integer published_time
 * @property integer created_at
 * @property integer updated_at
 * @property boolean published
 * @property boolean deleted
 *
 * @property Group $group
 * @property ArticleLang $lang
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Article extends ActiveRecord
{
    /**
     * @return null|object|string
     */
    public static function getDb()
    {
        return NewsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_article}}';
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
            [['group_id', 'create_time', 'update_time'], 'integer'],
            [
                ['published_time'],
                'date',
                'format' => 'php:' . NewsModule::getFormatDate(),
                'timestampAttribute' => 'published_time'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'image_link'], 'string', 'max' => 255],
            [['alias'], 'unique']
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
            'backend' => ['group_id', 'alias', 'image_link', 'published', 'deleted', 'published_time'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group'),
            'alias' => Yii::t('app', 'Alias'),
            'image_link' => Yii::t('app', 'Image link'),
            'published_time' => Yii::t('app', 'Published time'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ArticleLang::class, ['rid' => 'id']);
    }

    /**
     * @return string
     */
    public function getPublishedTime()
    {
        $format = NewsModule::getFormatDate();
        return $this->published_time == 0 ? date($format) : date($format, $this->published_time);
    }

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getPublishedTimeISO()
    {
        return date('Y-m-d\TH:i:sO', $this->published_time);
    }
}
