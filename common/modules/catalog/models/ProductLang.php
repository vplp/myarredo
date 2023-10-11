<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\ActiveRecordLang;
use common\modules\catalog\Catalog;
use common\modules\sys\models\Language;

/**
 * Class ProductLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $title_for_list
 * @property string $description
 * @property string $content
 * @property string $comment
 * @property integer $mark
 *
 * @property Product $parent
 *
 * @package common\modules\catalog\models
 */
class ProductLang extends ActiveRecordLang
{
    const STATUS_KEY_ON = '1';
    const STATUS_KEY_OFF = '0';

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_item_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['rid', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            [['title', 'title_for_list'], 'string', 'max' => 255],
            //[['title'], 'unique'],
            [['description', 'content', 'comment'], 'string'],
            [['title', 'description', 'content', 'comment'], 'default', 'value' => ''],
            [['mark'], 'in', 'range' => array_keys(static::statusKeyRange())],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'title_for_list', 'description', 'content', 'comment', 'mark'],
            'frontend' => ['title', 'title_for_list', 'description', 'content', 'comment', 'mark'],
            'translation' => ['title', 'title_for_list', 'description', 'content', 'comment', 'mark'],
            'mark' => ['mark'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'title_for_list' => Yii::t('app', 'Title for list'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @return array
     */
    public static function statusKeyRange()
    {
        return [
            static::STATUS_KEY_ON => Yii::t('app', 'KEY_ON'),
            static::STATUS_KEY_OFF => Yii::t('app', 'KEY_OFF')
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->title == '') {
            $this->title = (!empty($this->parent->types->lang) ? $this->parent->types->lang->title : '')
                . (!empty($this->parent->factory) ? ' ' . $this->parent->factory->title : '')
                . (($this->parent->article && $this->parent->is_composition == '0') ? ' ' . $this->parent->article : '');
        }

        if ($this->title_for_list == '') {
            $this->title_for_list = (!empty($this->parent->types->lang) ? $this->parent->types->lang->title : '')
                . (($this->parent->article && $this->parent->is_composition == '0') ? ' ' . $this->parent->article : '');
        }

//        if ($this->parent->is_composition && strpos($this->title, Yii::t('app', 'Композиция')) === false) {
//            $this->title = Yii::t('app', 'Композиция') . ' ' . $this->title;
//        }

        if (in_array($this->scenario, ['frontend', 'backend', 'translation'])) {
            $this->mark = '1';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param $insert
     * @param $changedAttributes
     * @return void
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (in_array($this->scenario, ['frontend', 'backend'])) {

            $currentLanguage = Yii::$app->language;

            $modelLanguage = new Language();
            $languages = $modelLanguage->getLanguages();

            foreach ($languages as $language2) {
                if ($language2['local'] != $currentLanguage) {
                    Yii::$app->language = $language2['local'];

                    /** @var $modelLang2 ProductLang */
                    $modelLang2 = ProductLang::find()
                        ->where([
                            'rid' => $this->rid,
                            'lang' => Yii::$app->language,
                        ])
                        ->one();

                    if ($modelLang2 == null) {
                        $modelLang2 = new ProductLang();
                        $modelLang2->rid = $this->rid;
                        $modelLang2->lang = Yii::$app->language;
                        $modelLang2->mark = '0';
                        $modelLang2->setScenario('backend');
                        $modelLang2->save();
                    } else {
                        $modelLang2->mark = '0';
                        $modelLang2->setScenario('mark');
                        $modelLang2->save();
                    }
                }
            }

            Yii::$app->language = $currentLanguage;
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Product::class, ['id' => 'rid']);
    }
}
