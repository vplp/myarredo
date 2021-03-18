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
 * @property string $description
 * @property string $content
 * @property string $contacts
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $working_conditions
 * @property string $subdivision
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
            ['rid', 'exist', 'targetClass' => Factory::class, 'targetAttribute' => 'id'],
            [['h1', 'meta_title', 'meta_desc'], 'string', 'max' => 255],
            [['description', 'content', 'contacts', 'working_conditions', 'subdivision'], 'string'],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'h1',
                'meta_title',
                'meta_desc',
                'description',
                'content',
                'contacts',
                'working_conditions',
                'subdivision'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'contacts' => 'Контакты',
            'h1' => 'H1',
            'meta_title' => 'Meta title',
            'meta_desc' => 'Meta desc',
            'working_conditions' => Yii::t('app', 'Условия работы'),
            'subdivision' => Yii::t('app', 'Представительство'),
        ];
    }
}
