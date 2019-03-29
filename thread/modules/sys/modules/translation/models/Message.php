<?php

namespace thread\modules\sys\modules\translation\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\sys\modules\translation\Translation as TranslationModule;

/**
 * Class Message
 *
 * @property integer $rid
 * @property string $lang
 * @property string $translation
 *
 * @package thread\modules\sys\modules\translation\models
 */
class Message extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return TranslationModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%translation_message}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['translation'], 'required'],
            ['rid', 'exist', 'targetClass' => Source::class, 'targetAttribute' => 'id'],
            ['translation', 'string'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['translation'],
            'translation' => ['translation']
        ];
    }
}
