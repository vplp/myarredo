<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\ActiveRecordLang;
use common\modules\catalog\Catalog;

/**
 * Class FactoryLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $contacts
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_desc
 *
 * @package common\modules\catalog\models
 */
class FactoryLang extends ActiveRecordLang
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
        return '{{%catalog_factory_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Factory::class, 'targetAttribute' => 'id'],
            [['title', 'h1', 'meta_title', 'meta_desc'], 'string', 'max' => 255],
            [['description', 'content', 'contacts'], 'string'],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'h1', 'meta_title', 'meta_desc', 'description', 'content', 'contacts'],
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
            'contacts' => 'Контакты',
            'h1' => 'H1',
            'meta_title' => 'Meta title',
            'meta_desc' => 'Meta desc',
        ];
    }
}
