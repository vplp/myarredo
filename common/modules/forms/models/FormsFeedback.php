<?php

namespace common\modules\forms\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\forms\FormsModule;
use common\modules\user\models\User;

/**
 * Class Forms
 *
 * @property integer $id
 * @property integer $partner_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property string attachment
 *
 * @property User $partner
 *
 * @package common\modules\forms\models
 */
class FormsFeedback extends ActiveRecord
{
    public $user_agreement;

    public $reCaptcha;

    public $attachment;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%forms_feedback}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'comment'], 'required'],
            [['user_agreement', 'reCaptcha'], 'required', 'on' => 'frontend'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 2048],
            [['partner_id'], 'integer'],
            [['email'], 'email'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['created_at', 'updated_at', 'published', 'deleted'], 'integer'],
            [['user_agreement'], 'in', 'range' => [0, 1]],
            [
                ['user_agreement'],
                'required',
                'on' => ['frontend'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [
                ['attachment'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'rar, zip, doc, docx, xlsx, xls, jpeg, png'
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class]
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
            'backend' => ['name', 'email', 'phone', 'comment', 'published'],
            'frontend' => [
                'partner_id',
                'name',
                'email',
                'phone',
                'comment',
                'published',
                'user_agreement',
                'reCaptcha'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'partner_id' => Yii::t('app', 'Partner'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'user_agreement' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>'),
            'reCaptcha' => 'Captcha',
            'attachment' => Yii::t('app', 'File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(User::class, ['id' => 'partner_id']);
    }

    /**
     * @return string
     */
    public function getPublishedTime()
    {
        $format = FormsModule::getFormatDate();
        return $this->created_at == 0 ? date($format) : date($format, $this->created_at);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.id DESC');
    }
}
