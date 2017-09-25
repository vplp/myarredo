<?php

namespace thread\modules\sys\modules\mailcarrier\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class MailCarrier
 *
 * @package thread\modules\sys\modules\mailcarrier\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailCarrier extends ActiveRecord
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
        return '{{%system_mail_carrier}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['mailbox_id', 'send_to', 'subject', 'from_email'], 'required'],
            ['mailbox_id', 'exist', 'targetClass' => MailBox::class, 'targetAttribute' => 'id'],
            [['created_at', 'updated_at', 'mailbox_id'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'path_to_layout', 'path_to_view', 'from_user', 'from_email'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 32],
            [['send_to', 'send_bcc', 'send_cc', 'subject'], 'string', 'max' => 4096],
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
            'mailbox_id' => ['mailbox_id'],
            'backend' => ['alias', 'mailbox_id', 'created_at', 'updated_at', 'published', 'deleted', 'path_to_layout', 'path_to_view', 'from_user', 'from_email', 'send_to', 'send_bcc', 'send_cc', 'subject'],
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
            'mailbox_id' => Yii::t('sys', 'MailBox'),
            'path_to_layout' => Yii::t('sys', 'MailCarrier: Path to layouts'),
            'path_to_view' => Yii::t('sys', 'MailCarrier: Path to views'),
            'from_user' => Yii::t('sys', 'MailCarrier: From user'),
            'from_email' => Yii::t('sys', 'MailCarrier: From email'),
            'send_to' => Yii::t('sys', 'MailCarrier: Send to'),
            'send_bcc' => Yii::t('sys', 'MailCarrier: Send bcc'),
            'send_cc' => Yii::t('sys', 'MailCarrier: Send cc'),
            'subject' => Yii::t('sys', 'MailCarrier: Subject'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->hasOne(MailCarrierLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getMailbox()
    {
        return $this->hasOne(MailBox::class, ['id' => 'mailbox_id']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title)) ? $this->lang->title : "{{$this->default_title}}";
    }

}
