<?php

namespace thread\modules\configs\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\configs\Configs as ConfigsModule;

/**
 * Class ParamsLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\configs\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class ParamsLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return ConfigsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%configs_params_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Topic::class, 'targetAttribute' => 'id'],
            ['title', 'string', 'max' => 255],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'RID'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Title'),
        ];
    }
}
