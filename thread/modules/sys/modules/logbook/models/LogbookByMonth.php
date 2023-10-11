<?php

namespace thread\modules\sys\modules\logbook\models;

use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\logbook\Logbook as ParentModule;
use thread\modules\user\models\User;
use Yii;

/**
 * Class LogbookByMonth
 *
 * @package thread\modules\sys\modules\logbook\models
 *
 * @property $id
 * @property $user_id
 * @property $action_method
 * @property $action_date
 * @property $count
 * @property $published
 * @property $deleted
 */
class LogbookByMonth extends ActiveRecord
{

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
        return '{{%system_logbook_by_month}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'action_method', 'action_date', 'count'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'action_date', 'count'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => \array_keys(static::statusKeyRange())],
            [['action_method'], 'string', 'max' => 512],

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
                'user_id',
                'action_method',
                'action_date',
                'count',
                'published',
                'deleted',
            ],
            'send' => [
                'user_id',
                'action_method',
                'action_date',
                'count',
                'published',
                'deleted',
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
            'user_id' => Yii::t('app', 'User'),
            'action_method' => Yii::t('app', 'Title'),
            'action_date' => 'Дата',
            'count' => 'Кол-во',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
