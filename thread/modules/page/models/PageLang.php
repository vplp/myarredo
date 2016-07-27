<?php

namespace thread\modules\page\models;

use thread\app\base\models\ActiveRecordLang;
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\Language;
use thread\modules\page\Page as PageModel;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

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
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class PageLang extends ActiveRecordLang
{
    /**
     * Db connection
     * @return string
     */
    public static function getDb()
    {
        return PageModel::getDb();
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
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'content' => Yii::t('app', 'content'),
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

    /**
     * @return ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(PageModel::class, ['rid' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Language::class, ['lang' => 'id']);
    }
}
