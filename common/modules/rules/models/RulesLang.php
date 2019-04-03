<?php

namespace common\modules\rules\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\rules\RulesModule;
use thread\app\base\models\ActiveRecordLang;

/**
 * Class RulesLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $content
 *
 * @package common\modules\rules\models
 */
class RulesLang extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return rulesModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%rules_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Rules::class, 'targetAttribute' => 'id'],
            ['title', 'string', 'max' => 255],
            [['content'], 'string'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'content'],
        ];
    }
}
