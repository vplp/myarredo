<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\sys\models\Language;
use common\modules\catalog\Catalog;
//
use thread\app\base\models\ActiveRecordLang;

/**
 * Class ItalianProductLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $defects
 * @property string $material
 *
 * @package common\modules\catalog\models
 */
class ItalianProductLang extends ActiveRecordLang
{
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
        return '{{%catalog_italian_item_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => ItalianProduct::class, 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 255],
            [['defects', 'material'], 'string', 'max' => 1024],
            [['description', 'content'], 'string'],
            [['description', 'content'], 'default', 'value' => '']
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'description', 'content', 'defects', 'material'],
            'frontend' => ['title', 'description', 'defects', 'material'],
        ];
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
            'defects' => Yii::t('app', 'Defects'),
            'material' => Yii::t('app', 'Material'),
        ];
    }

//    /**
//     * @param bool $insert
//     * @param array $changedAttributes
//     */
//    public function afterSave($insert, $changedAttributes)
//    {
//        $models = Language::findBase()->enabled()->all();
//
//        $current = Yii::$app->language;
//
//        foreach ($models as $model) {
//            if ($model->local != $current) {
//                /** @var Language $model */
//                Yii::$app->language = $model->local;
//
//                $modelLang = ItalianProductLang::find()
//                    ->where([
//                        'rid' => $model->id
//                    ])
//                    ->one();
//
//                if ($modelLang == null) {
//                    $modelLang = new ItalianProductLang();
//
//                    $modelLang->rid = $model->id;
//                    $modelLang->lang = Yii::$app->language;
//                }
//
//                $language = substr($current, 0, 2) . '-' . substr(Yii::$app->language, 0, 2);
//
//                if ($this->title != '') {
//                    $modelLang->title = Yii::$app->yandexTranslator
//                        ->getTranslate($this->title, $language);
//                }
//
//                if ($this->description != '') {
//                    $modelLang->description = Yii::$app->yandexTranslator
//                        ->getTranslate($this->description, $language);
//                }
//
//                if ($this->defects != '') {
//                    $modelLang->defects = Yii::$app->yandexTranslator
//                        ->getTranslate($this->defects, $language);
//                }
//
//                $modelLang->setScenario('backend');
//
//                $modelLang->save();
//            }
//        }
//
//        Yii::$app->language = $current;
//
//        parent::afterSave($insert, $changedAttributes);
//    }
}
