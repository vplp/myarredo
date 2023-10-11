<?php

namespace thread\modules\seo\modules\info\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\seo\modules\info\Info as ParentModule;

/**
 * Class InfoLang
 *
 * @package thread\modules\seo\modules\info\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class InfoLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return ParentModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo_info_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Info::class, 'targetAttribute' => 'id'],
            [['title', 'value'], 'string', 'max' => 255],
        ]);
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'value'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
