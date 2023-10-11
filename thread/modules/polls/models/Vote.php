<?php

namespace thread\modules\polls\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\polls\Polls as PollsModule;

/**
 * Class Vote
 *
 * @property integer id
 * @property integer group_id
 * @property integer created_at
 * @property integer updated_at
 * @property boolean published
 * @property boolean deleted
 *
 * @property Poll $poll
 * @property VoteLang $lang
 *
 * @package thread\modules\polls\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Vote extends ActiveRecord
{
    /**
     * @return null|object|string
     */
    public static function getDb()
    {
        return PollsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%polls_vote}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['group_id', 'create_time', 'update_time', 'number_of_votes', 'position'], 'integer'],
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
            'backend' => ['group_id', 'published', 'deleted', 'number_of_votes', 'position'],
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
            'number_of_votes' => Yii::t('app', 'Number of votes'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Poll::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(VoteLang::class, ['rid' => 'id']);
    }
}
