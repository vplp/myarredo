<?php

namespace thread\modules\forms\models;
use thread\app\base\models\ActiveRecord;
use thread\app\base\models\query\ActiveQuery;
use thread\modules\forms\Forms;
use Yii;


/**
 * Class Topic
 *
 * @property integer $id
 * @property string $sort
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property TopicLang $lang
 * @property FeedbackForm[] $feedbacks
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Topic extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Forms::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feedback_topics}}';
    }




    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'sort'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'backend' => ['published', 'deleted', 'sort'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(TopicLang::class, ['rid' => 'id']);
    }

    public function getFeedbacks()
    {
        return $this->hasMany(FeedbackForm::class, ['topic_id' => 'id']);
    }
}
