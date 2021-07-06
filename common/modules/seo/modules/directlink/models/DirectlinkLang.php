<?php

namespace common\modules\seo\modules\directlink\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\ActiveRecordLang;
use common\modules\seo\modules\directlink\Directlink as ParentModule;

/**
 * Class DirectlinkLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $content
 * @property string $h1
 * @property string $description
 * @property string $keywords
 *
 * @package common\modules\seo\modules\directlink\models
 */
class DirectlinkLang extends ActiveRecordLang
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return ParentModule::getDb();
    }

    /**
     * @inheritdoc
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo_direct_link_lang}}';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['title'], 'required'],
                ['rid', 'exist', 'targetClass' => Directlink::class, 'targetAttribute' => 'id'],
                ['content', 'string'],
                [['title', 'h1',  'keywords'], 'string', 'max' => 255],
                [['description'], 'string', 'max' => 500],
                [['description', 'keywords', 'h1', 'content'], 'default', 'value' => ''],
            ]
        );
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'description' => Yii::t('app', 'Description'),
            'h1' => 'H1',
            'keywords' => Yii::t('seo', 'Keywords'),
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'content', 'h1', 'description', 'keywords'],
        ];
    }
}
