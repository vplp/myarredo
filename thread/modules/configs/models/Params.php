<?php

namespace thread\modules\configs\models;

use Yii;
//
use thread\app\base\models\{
    ActiveRecord, query\ActiveQuery
};
use thread\modules\configs\Configs as ConfigsModule;


/**
 * Class Topic
 *
 * @property integer $id
 * @property string $sort
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property ParamsLang $lang
 *
 * @package thread\modules\configs\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Params extends ActiveRecord
{
    /**
     * @return string
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
        return '{{%configs_params}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'value'], 'required'],
            [['alias'], 'unique'],
            [['alias'], 'string', 'max' => 255],
            ['value', 'string', 'max' => 1024],
            [['created_at', 'updated_at', 'sort'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
