<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\catalog\Catalog;
use thread\app\base\models\ActiveRecordLang;

/**
 * Class ItalianProductLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $title_for_list
 * @property string $description
 * @property string $content
 * @property string $defects
 * @property string $material
 *
 * @property ItalianProduct $parent
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
            ['rid', 'exist', 'targetClass' => ItalianProduct::class, 'targetAttribute' => 'id'],
            [['title', 'title_for_list'], 'string', 'max' => 255],
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
            'setImages' => [],
            'backend' => ['title', 'title_for_list', 'description', 'defects', 'material'],
            'frontend' => ['title', 'title_for_list', 'description', 'defects', 'material'],
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
            'defects' => Yii::t('app', 'Defects'),
            'material' => Yii::t('app', 'Material'),
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
                . (($this->parent->article) ? ' ' . $this->parent->article : '');
        }

        if ($this->title_for_list == '') {
            $this->title_for_list = (!empty($this->parent->types->lang) ? $this->parent->types->lang->title : '')
                . (($this->parent->article) ? ' ' . $this->parent->article : '');
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ItalianProduct::class, ['id' => 'rid']);
    }
}
