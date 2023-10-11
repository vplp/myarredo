<?php

namespace thread\modules\correspondence\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\correspondence\Correspondence as ModuleСorrespondence;

/**
 * Class Сorrespondence
 *
 * @package thread\modules\correspondence\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Correspondence extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return ModuleСorrespondence::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%correspondence}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['recipient_id', 'subject'], 'required'],
            [['created_at', 'updated_at', 'sender_id', 'recipient_id'], 'integer'],
            [['published', 'deleted', 'is_read'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['subject'], 'string', 'max' => 255],
            [['message'], 'string']
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
            'is_read' => ['is_read'],
            'backend' => ['published', 'deleted', 'recipient_id', 'subject', 'message', 'is_read'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender'),
            'recipient_id' => Yii::t('app', 'Recipient'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'is_read' => Yii::t('app', 'Is read'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        /**
         * @var \thread\modules\correspondence\Сorrespondence $module
         */
        $module = Yii::$app->getModule('correspondence');
        return $this->hasOne($module->userClass, ['id' => 'sender_id']);
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        /**
         * @var \thread\modules\correspondence\Сorrespondence $module
         */
        $module = Yii::$app->getModule('correspondence');
        return $this->hasOne($module->userClass, ['id' => 'recipient_id']);
    }

    /**
     * @return string
     */
    public function getPublishedTime()
    {
        $format = ModuleСorrespondence::getFormatDate();
        return $this->updated_at == 0 ? date($format) : date($format, $this->updated_at);
    }

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getPublishedTimeISO()
    {
        return date('Y-m-d\TH:i:sO', $this->updated_at);
    }

}
