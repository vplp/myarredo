<?php

namespace thread\modules\sys\modules\translation\models;

use thread\app\base\models\ActiveRecord;
use thread\modules\sys\modules\translation\Translation;
use thread\modules\sys\modules\translation\components\DbMessageSource;
use thread\modules\sys\modules\translation\Translation as TranslationModule;

/**
 * Class Source
 *
 * @property integer $id
 * @property string $key
 * @property string $category
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property \thread\modules\sys\modules\translation\models\Message $message
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package thread\modules\sys\modules\translation\models
 */
class Source extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return TranslationModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%translation_source}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['key', 'category'], 'string'],
            [['key', 'category'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['published', 'deleted', 'key', 'category'],
        ];
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->hasOne(Message::class, ['rid' => 'id']);
    }

    /**
     * @param $category
     * @param $key
     * @return mixed
     */
    public static function existKey($category, $key)
    {
        return self::findBase()
            ->andWhere(['category' => $category, 'key' => $key])
            ->exists();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $data = new DbMessageSource();
        $data->cleanCache();

        return parent::beforeSave($insert);
    }
}
