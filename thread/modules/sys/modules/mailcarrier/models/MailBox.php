<?php

namespace thread\modules\sys\modules\mailcarrier\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class MailBox
 *
 * @package thread\modules\sys\modules\mailcarrier\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailBox extends ActiveRecord
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
        return '{{%system_mail_box}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['host', 'username', 'password', 'port'], 'required'],
            [['created_at', 'updated_at', 'port'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['host', 'username', 'password'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 32],
            [['encryption'], 'in', 'range' => static::statusEncryptionRange()],
            [['port'], 'default', 'value' => 25],
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
            'backend' => ['alias', 'host', 'username', 'password', 'port', 'encryption', 'created_at', 'updated_at', 'published', 'deleted'],
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
            'host' => Yii::t('sys', 'MailCarrier: Host'),
            'username' => Yii::t('sys', 'MailCarrier: Username'),
            'password' => Yii::t('sys', 'MailCarrier: Password'),
            'port' => Yii::t('sys', 'MailCarrier: Port'),
            'encryption' => Yii::t('sys', 'MailCarrier: Encryption'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return array
     */
    public static function statusEncryptionRange()
    {
        return [
            '' => '',
            'tls' => 'tls',
            'ssl' => 'ssl',
        ];
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->hasOne(MailBoxLang::class, ['rid' => 'id']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title)) ? $this->lang->title : "{{$this->default_title}}";
    }
}
