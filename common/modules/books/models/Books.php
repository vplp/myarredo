<?php

namespace common\modules\books\models;

use Yii;
use thread\app\base\models\ActiveRecord;

/**
 * Class Files
 *
 * @property integer $id
 * @property integer $book_id
 * @property string $email
 * @property string $name
 * @property integer $active
 *
 * @package common\modules\books\models
 */
class Books extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%books}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 255],
            [['book_id', 'active'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['name', 'email', 'book_id', 'active'],
            'frontend' => ['name', 'email', 'book_id', 'active'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'book_id' => Yii::t('app', 'E-mail company'),
            'active' => Yii::t('app', 'Active'),
        ];
    }


    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.id DESC');
    }



    public static function addEmails($bookId, $emails)
    {
        foreach ($emails as $email) {
            $model = self::find()->where(['book_id'=>$bookId, 'email'=>$email['email']])->one();
            if (empty($model)) {
                $model = new Books();
            }
            $model->setScenario('backend');
            $model->book_id = $bookId;
            $model->email = $email['email'];
            $model->name = $email['variables']['name'];
            $model->active = 1;
            $model->save();
        }
    }

    public static function removeEmails($bookId, $emails)
    {
        foreach ($emails as $email) {
            $model = self::find()->where(['book_id'=>$bookId, 'email'=>$email])->one();
            if (empty($model)) {
                continue;
            }
            $model->setScenario('backend');
            $model->active = 0;
            $model->save();
        }
    }

    /**
    * @return mixed
    */
    public static function getCampaign($bookId)
    {
        return self::find()->where(['book_id'=>$bookId, 'active'=> '1'])->all();
    }
}
