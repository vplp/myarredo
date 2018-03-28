<?php

namespace thread\modules\sys\modules\configs\models;

use Yii;
//
use thread\app\base\models\{
    ActiveRecord, query\ActiveQuery
};
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class Params
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $alias
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property ParamsLang $lang
 *
 * @package thread\modules\sys\modules\configs\models
 */
class Params extends ActiveRecord
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
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
        return '{{%system_configs_params}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['alias'], 'unique'],
            [['alias'], 'string', 'max' => 255],
            ['value', 'string'],
            [['created_at', 'updated_at', 'sort'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['value'], 'default', 'value' => ''],
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
            'backend' => ['published', 'deleted', 'value', 'alias', 'group_id'],
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
            'group_id' => Yii::t('app', 'Group'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ParamsLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

}
