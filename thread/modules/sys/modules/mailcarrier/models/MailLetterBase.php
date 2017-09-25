<?php

namespace thread\modules\sys\modules\mailcarrier\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class MailLetterBase
 *
 * @package thread\modules\sys\modules\mailcarrier\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailLetterBase extends ActiveRecord
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
        return '{{%system_mail_letter_base}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['letter'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['letter'], 'string'],
            [['carrier'], 'default', 'value' => 255],
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
            'backend' => ['carrier', 'letter', 'created_at', 'updated_at', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'carrier' => Yii::t('sys', 'MailCarrier: Carrier'),
            'letter' => Yii::t('sys', 'MailCarrier: Letter'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
