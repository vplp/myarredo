<?php

namespace thread\modules\menu\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecordLang;

/**
 * Class MenuLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 *
 * @package thread\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuLang extends ActiveRecordLang
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return \thread\modules\menu\Menu::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%menu_lang}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['title'], 'required'],
                ['rid', 'exist', 'targetClass' => Menu::class, 'targetAttribute' => 'id'],
                ['title', 'string', 'max' => 255],
            ]
        );
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
