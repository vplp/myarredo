<?php

namespace common\modules\banner\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\banner\BannerModule;
//
use thread\app\base\models\ActiveRecordLang;

/**
 * Class BannerItemLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 *
 * @package common\modules\banner\models
 */
class BannerItemLang extends ActiveRecordLang
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return BannerModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%banner_item_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => BannerItem::class, 'targetAttribute' => 'id'],
            [['title', 'link'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024]
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
            'description' => Yii::t('app', 'Description'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'description', 'link'],
        ];
    }
}
