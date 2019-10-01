<?php

namespace common\modules\rules\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\rules\RulesModule;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Rules
 *
 * @property integer $id
 * @property integer position
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @property RulesLang $lang
 *
 * @package common\modules\rules\models
 */
class Rules extends ActiveRecord
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return RulesModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%rules}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['position', 'created_at', 'updated_at'], 'integer'],
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
            'backend' => [
                'position',
                'published',
                'deleted',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(["lang"])->orderBy(['position' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(RulesLang::class, ['rid' => 'id']);
    }

    /**
     * Title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = $this->lang->title ?? '{{-}}';

        return $title;
    }
}
