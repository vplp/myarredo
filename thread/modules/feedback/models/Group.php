<?php

namespace thread\modules\feedback\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\feedback\Feedback as ParentModule;

/**
 * Class Group
 *
 * @package thread\modules\feedback\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return ParentModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feedback_group}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['position'], 'default', 'value' => 0]
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
            'backend' => ['published', 'deleted', 'position'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->hasOne(GroupLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['group_id' => 'id']);
    }
}
