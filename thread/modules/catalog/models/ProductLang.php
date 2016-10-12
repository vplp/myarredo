<?php

namespace thread\modules\catalog\models;

use Yii;
//
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class ProductLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property string $content
 *
 * @package thread\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class ProductLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return CatalogModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_product_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'id'],
            ['title', 'string', 'max' => 255],
            ['description', 'string', 'max' => 1024],
            ['content', 'string'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'Content' => Yii::t('app', 'content'),
        ];
    }
}