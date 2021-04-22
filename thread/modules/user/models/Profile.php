<?php

namespace thread\modules\user\models;

use Yii;
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
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
            'first_name' => Yii::t('user', 'First name'),
            'last_name' => Yii::t('user', 'Last name'),
            'avatar' => Yii::t('user', 'Avatar'),
            'preferred_language' => Yii::t('user', 'Preferred language'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::class, ['id' => 'user_id']);
    }

    /**
     * @return null|string
     */
    public function getAvatarImage()
    {
        /**
         * @var $module \thread\modules\user\User
         */
        $module = Yii::$app->getModule('user');
        $path = $module->getAvatarUploadPath($this->user_id);
        $url = $module->getAvatarUploadUrl($this->user_id);

        $image = null;
        if (!empty($this->avatar) && is_file($path . '/' . $this->avatar)) {
            $image = $url . '/' . $this->avatar;
        }
        return $image;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function findByUserId($user_id)
    {
        return self::find()->user_id($user_id)->one();
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return bool
     */
    public function showWorkingConditions()
    {
        $res = false;

        if (in_array($this->user->group->role, ['admin', 'settlementCenter'])) {
            $res = true;
        } elseif (in_array($this->user->group->role, ['partner']) && $this->working_conditions) {
            $res = true;
        }

        return $res;
    }
}
