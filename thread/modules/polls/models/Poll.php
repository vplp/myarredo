<?php

namespace thread\modules\polls\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\polls\Polls as PollsModule;

/**
 * Class Poll
 *
 * @property integer $id
 * @property integer published_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property PollLang $lang
 * @property Vote[] $votes
 *
 * @package thread\modules\polls\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Poll extends ActiveRecord
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
        return '{{%polls_poll}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'number_of_votes'], 'integer'],
            [
                ['start_time'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'start_time'
            ],
            [
                ['finish_time'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'finish_time'
            ],
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
            'backend' => ['published', 'deleted', 'start_time', 'finish_time', 'number_of_votes'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number_of_votes' => Yii::t('app', 'Number of votes'),
            'start_time' => Yii::t('app', 'Start time'),
            'finish_time' => Yii::t('app', 'Finish time'),
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
        return $this->hasOne(PollLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::class, ['group_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getStartTime()
    {
        $format = PollsModule::getFormatDate();
        return $this->start_time == 0 ? date($format) : date($format, $this->start_time);
    }

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getStartTimeISO()
    {
        return date('Y-m-d\TH:i:sO', $this->start_time);
    }

    /**
     * @return string
     */
    public function getFinishTime()
    {
        $format = PollsModule::getFormatDate();
        return $this->finish_time == 0 ? date($format) : date($format, $this->finish_time);
    }

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getFinishTimeISO()
    {
        return date('Y-m-d\TH:i:sO', $this->finish_time);
    }
}
