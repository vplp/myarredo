<?php

namespace thread\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\news\News as NewsModule;

/**
 * Class GroupLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class GroupLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return NewsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_group_lang}}';
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
            'rid' => Yii::t('app', 'RID'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Title'),
        ];
    }
}
