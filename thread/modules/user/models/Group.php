<?php

namespace thread\modules\user\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector
};
//
use thread\app\base\models\ActiveRecord;
use thread\modules\user\User as UserModule;

/**
 * Class Group
 *
 * @property integer $id
 * @property string $alias
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property GroupLang $lang
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Group extends ActiveRecord
{
    const ADMIN = '1';
    const USER = '2';

    /**
     * @var
     */
    public static $commonQuery = query\GroupQuery::class;

    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return UserModule::getDb();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias);
                },
            ],
        ]);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_group}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'role'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['role'], 'string', 'max' => 45],
            [['role'], 'default', 'value' => 'guest'],
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
            'backend' => ['alias', 'role', 'published', 'deleted'],
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
            'role' => Yii::t('user', 'Role'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(GroupLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, ['group_id' => 'id']);
    }

    /**
     * @param $role
     * @return mixed
     */
    public static function getIdsByRole($role)
    {
        return self::find()->select('id')->role($role)->column();
    }
}
