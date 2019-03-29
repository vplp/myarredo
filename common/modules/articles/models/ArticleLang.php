<?php

namespace common\modules\articles\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\articles\Articles as ArticlesModule;
use thread\app\base\models\ActiveRecordLang;

/**
 * Class ArticleLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property string $content
 *
 * @package common\modules\articles\models
 */
class ArticleLang extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return ArticlesModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%articles_article_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
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
