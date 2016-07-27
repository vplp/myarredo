<?php

namespace thread\modules\forms\models;
use thread\app\base\models\ActiveRecordLang;
use thread\modules\forms\Forms;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class TopicLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class TopicLang extends ActiveRecordLang
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Forms::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feedback_topics_lang}}';
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
