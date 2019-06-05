<?php

namespace thread\modules\page\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\page\Page as PageModule;

/**
 * Class PageLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $content
 *
 * @property Page[] $pages
 * @property PageLang[] $langs
 *
 * @package thread\modules\page\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PageLang extends ActiveRecordLang
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return PageModule::getDb();
    }

    /**
     * @inheritdoc
     * @return string
     */
    public static function tableName()
    {
        return '{{%page_lang}}';
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
                ['rid', 'exist', 'targetClass' => Page::class, 'targetAttribute' => 'id'],
                ['content', 'string'],
                ['title', 'string', 'max' => 255],
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
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'content'],
        ];
    }
}
