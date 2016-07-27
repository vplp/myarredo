<?php

namespace thread\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\modules\news\News as NewsModule;
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
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roma Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class ArticleLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return NewsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_article_lang}}';
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
            ['content', 'string'],
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
