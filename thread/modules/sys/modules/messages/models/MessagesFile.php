<?php

namespace thread\modules\sys\modules\messages\models;

use Yii;
//
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\{
    ActiveRecord, query\ActiveQuery
};
use thread\modules\sys\modules\messages\Messages as mMessages;


/**
 * Class MessagesFile
 *
 * @package thread\modules\sys\modules\messages\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MessagesFile extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return mMessages::getDb();
    }

    /**
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_messages_file}}';
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
                    return md5($this->messagefilepath);
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
            [['messagefilepath'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['messagefilepath'], 'string', 'max' => 512],
            [['messagefilepath'], 'unique']
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['messagefilepath', 'alias'],
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
            'messagefilepath' => Yii::t('messages', 'messagefilepath'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
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
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(MessagesFileLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Messages::class, ['group_id' => 'id']);
    }

    /**
     * @param $filepath
     * @return mixed
     */
    public static function findByFilePath($filepath)
    {
        return self::find()->messagefilepath($filepath)->one();
    }
}
