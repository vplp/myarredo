<?php

namespace common\modules\promotion\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\promotion\PromotionModule;
use thread\app\base\models\ActiveRecordLang;

/**
 * Class PromotionPackageLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property string $content
 *
 * @package common\modules\promotion\models
 */
class PromotionPackageLang extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return PromotionModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%promotion_package_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => PromotionPackage::class, 'targetAttribute' => 'id'],
            ['title', 'string', 'max' => 255],
            ['description', 'string', 'max' => 1024],
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
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'description', 'content'],
        ];
    }
}
