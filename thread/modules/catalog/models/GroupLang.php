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
 * Class GroupLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class GroupLang extends ActiveRecordLang
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
        return '{{%catalog_group_lang}}';
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
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
        ];
    }
}