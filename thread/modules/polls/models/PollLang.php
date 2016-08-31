<?php

namespace thread\modules\polls\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;
use thread\modules\polls\Polls as PollsModule;

/**
 * Class PollLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class PollLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return PollsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%polls_poll_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Poll::class, 'targetAttribute' => 'id'],
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
