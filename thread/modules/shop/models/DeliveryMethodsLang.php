<?php

namespace thread\modules\shop\models;

use thread\app\base\models\ActiveRecordLang;
use Yii;

/**
 * Class DeliveryMethodsLang
 *
 * @package thread\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class DeliveryMethodsLang extends ActiveRecordLang
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return Shop::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%shop_delivery_methods_lang}}';
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['rid', 'lang', 'title'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => DeliveryMethods::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            ['title', 'string', 'max' => 255],
            [
                ['rid', 'lang'],
                'unique',
                'targetAttribute' => ['rid', 'lang'],
                'message' => 'The combination of rid and lang has already been taken.'
            ]
        ];
    }

    /**
     *
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
