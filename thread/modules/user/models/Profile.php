<?php
namespace thread\modules\user\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\user\User as UserModule;
use thread\modules\user\models\User as UserModel;

/**
 * class Profile
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property string $preferred_language
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Profile extends ActiveRecord
{
    /**
     * @var
     */
    public static $commonQuery = query\ProfileQuery::class;

    /**
     * @return string
     */
    public static function getDb()
    {
        return UserModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'unique'],
            ['user_id', 'exist', 'targetClass' => UserModel::className(), 'targetAttribute' => 'id'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'avatar', 'preferred_language'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['first_name', 'last_name', 'avatar', 'preferred_language'],
            'frontend' => ['first_name', 'last_name', 'avatar', 'preferred_language'],
            'ownEdit' => ['first_name', 'last_name', 'avatar', 'preferred_language'],
            'basicCreate' => ['user_id'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('app', 'First name'),
            'last_name' => Yii::t('app', 'Last name'),
            'avatar' => Yii::t('app', 'Avatar'),
            'preferred_language' => Yii::t('app', 'Preferred language'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function findByUserId($user_id)
    {
        return self::find()->user_id($user_id)->one();
    }
}
