<?php

namespace thread\modules\sys\modules\mailcarrier\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class GroupLang
 *
 * @package thread\modules\sys\modules\configs\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailBoxLang extends ActiveRecordLang
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
        return '{{%system_mail_box_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => MailBox::class, 'targetAttribute' => 'id'],
            ['title', 'string', 'max' => 255],
        ]);
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title'],
            'title' => ['title'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
        ];
    }
}
