<?php

namespace thread\modules\polls\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\polls\Polls as PollsModule;

/**
 * Class Member
 *
 * @property integer $id
 * @property integer $poll_id
 * @property integer $vote_id
 * @property integer $member_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package thread\modules\polls\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Member extends ActiveRecord
{
    /**
     * @return string
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
        return '{{%polls_member}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['poll_id', 'vote_id', 'member_id'], 'required'],
            [['poll_id', 'vote_id', 'member_id'], 'unique', 'targetAttribute' => ['poll_id', 'vote_id', 'member_id']],
            ['poll_id', 'exist', 'targetClass' => Poll::class, 'targetAttribute' => 'id'],
            ['vote_id', 'exist', 'targetClass' => Vote::class, 'targetAttribute' => 'id'],
            [['created_at', 'updated_at', 'poll_id', 'vote_id', 'member_id'], 'integer'],
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
            'backend' => ['published', 'deleted', 'poll_id', 'vote_id', 'member_id'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poll_id' => Yii::t('app', 'Poll'),
            'vote_id' => Yii::t('app', 'Vote'),
            'member_id' => Yii::t('app', 'Member'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time')
        ];
    }

}
