<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\catalog\Catalog;
//
use thread\app\base\models\ActiveRecordLang;

/**
 * Class ColorsLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package common\modules\catalog\models
 */
class ColorsLang extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
        return '{{%catalog_colors_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Colors::class, 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title'],
        ];
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
