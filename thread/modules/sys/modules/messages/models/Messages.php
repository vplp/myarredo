<?php

namespace thread\modules\sys\modules\messages\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\{
    ActiveRecord, query\ActiveQuery
};
use thread\modules\sys\modules\messages\Messages as mMessages;

/**
 * Class Messages
 *
 * @package thread\modules\sys\modules\messages\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Messages extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return mMessages::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_messages}}';
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
                    return md5($this->arraykey);
                },
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'arraykey'], 'required'],
            [['created_at', 'updated_at', 'group_id'], 'integer'],
            ['group_id', 'exist', 'targetClass' => MessagesFile::class, 'targetAttribute' => 'id'],
            [['alias'], 'string', 'max' => 255],
            [['on_default_lang'], 'string'],
            [['required'], 'string'],
            ['alias', 'unique', 'targetAttribute' => ['alias', 'group_id']]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['alias', 'arraykey', 'group_id', 'on_default_lang'],
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
            'group_id' => Yii::t('app', 'File'),
            'arraykey' => Yii::t('messages', 'Array key'),
            'on_default_lang' => Yii::t('messages', 'On default lang'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(MessagesLang::class, ['rid' => 'id']);
    }

    /**
     * @param string $arraykey
     * @return string
     */
    public static function getKey(string $arraykey)
    {
        return md5($arraykey);
    }

    /**
     * @param int $group_id
     * @return mixed
     */
    public static function findAllByGroupId(int $group_id)
    {
        return self::find()->with(['lang'])->group_id($group_id)->all();
    }

    /**
     * @param string $arraykey
     * @param int $groupId
     * @return mixed
     */
    public static function findByArrayKey(string $arraykey, int $groupId)
    {
        return self::find()->alias(self::getKey($arraykey))->andWhere(['group_id' => $groupId])->one();
    }
}
