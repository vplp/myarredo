<?php

namespace thread\modules\sys\modules\messages\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\sys\modules\messages\Messages as mMessages;

/**
 * Class MessagesLang
 *
 * @package thread\modules\sys\modules\messages\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MessagesLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return mMessages::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_messages_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'id'],
            ['title', 'string', 'max' => 255],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'RID'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Title'),
        ];
    }
}
