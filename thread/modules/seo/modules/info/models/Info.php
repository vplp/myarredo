<?php

namespace thread\modules\seo\modules\info\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\modules\info\Info as ParentModule;

/**
 * Class Info
 *
 * @package thread\modules\seo\modules\info\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Info extends ActiveRecord
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
        return '{{%seo_info}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'default_title'], 'string', 'max' => 255],
            [['alias'], 'unique']
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
            'backend' => ['alias', 'published', 'deleted', 'default_title'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'default_title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->hasOne(InfoLang::class, ['rid' => 'id']);
    }
}
