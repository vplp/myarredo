<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\ActiveRecordLang;
use common\modules\catalog\Catalog;

/**
 * Class ProductLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $comment
 *
 * @property Product $parent
 *
 * @package common\modules\catalog\models
 */
class ProductLang extends ActiveRecordLang
{
    /**
     * @return string
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
            [['title'], 'string', 'max' => 255],
            [['description', 'content', 'comment'], 'string'],
            [['description', 'content', 'comment'], 'default', 'value' => ''],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'description', 'content', 'comment'],
            'frontend' => ['title', 'description', 'content', 'comment'],
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
            'comment' => Yii::t('app', 'Comment'),
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
                . (!empty($this->parent->collection->lang) ? ' ' . $this->parent->collection->lang->title : '')
                . (($this->parent->article && $this->parent->is_composition == '0') ? ' ' . $this->parent->article : '');
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Product::class, ['id' => 'rid']);
    }
}