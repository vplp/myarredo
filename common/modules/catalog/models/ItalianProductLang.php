<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
//
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
}
