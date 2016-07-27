<?php

namespace thread\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\user\User as mUser;

/**
 * class GroupLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class GroupLang extends ActiveRecordLang
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return mUser::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_group_lang}}';
    }


    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Group::className(), 'targetAttribute' => 'id'],
        ]);
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
        ];
    }
}
