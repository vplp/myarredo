<?php
namespace frontend\modules\forms\models;

use Yii;
//
use thread\modules\forms\models\FeedbackForm as BaseFeedbackFormModel;
use yii\helpers\ArrayHelper;

/**
 * Class FeedbackForm
 * @package frontend\modules\forms\models
 *
 */
class FeedbackForm extends BaseFeedbackFormModel
{

    public $verifyCode;

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'addfeedback' => ['name', 'question', 'topic_id', 'email', 'phone'],
        ];
    }

    /**
     *
     * @return array
     */

    public function rules()
    {
        return [
            [['name', 'question', 'topic_id', 'email'], 'required'],
            [['create_time', 'update_time',], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['name', 'question'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 5],
            [['email'], 'email'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => 'your secret key']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('form', 'ID'),
            'topic_id' => Yii::t('form', 'Topic'),
            'name' => Yii::t('form', 'name'),
            'question' => Yii::t('form', 'question'),
            'email' => Yii::t('form', 'email'),
            'phone' => Yii::t('form', 'phone'),
            'created_at' => Yii::t('form', 'Create time'),
            'updated_at' => Yii::t('form', 'Update time'),
            'published' => Yii::t('form', 'Published'),
            'deleted' => Yii::t('form', 'Deleted'),
        ];
    }


    /**
     *
     * @return yii\db\ActiveQuery
     */
    public static function find_base()
    {
        return self::find()->enabled();
    }

    /**
     *
     * @param integer $id
     * @return ActiveRecord|null
     */
    public static function findById($id)
    {
        return self::find_base()->byID($id)->one();
    }

    /**
     *
     * @return array|null
     */
    public static function all()
    {
        return self::find_base()->all();
    }

}
