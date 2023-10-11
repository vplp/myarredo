<?php

namespace thread\modules\user\models;

use Yii;
use yii\web\IdentityInterface;
use thread\modules\sys\modules\logbook\models\LogbookAuthModel;
use thread\app\base\models\ActiveRecord;
use thread\modules\user\User as UserModule;

/**
 * Class User
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $username
 * @property string $auth_key
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property Profile $profile
 * @property Group $group
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var
     */
    public static $commonQuery = query\UserQuery::class;

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
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            [['username', 'email'], 'required'],
            [['group_id', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['username', 'password', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['auth_key'], 'string', 'max' => 32],
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
            'backend' => ['username', 'email', 'published', 'deleted', 'group_id'],
            'userCreate' => ['username', 'email', 'published', 'group_id'],
            'passwordChange' => ['password', 'password_hash'],
            'profile' => ['username'],
            'resetPassword' => ['password_reset_token'],
            'setPassword' => ['password', 'password_hash']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('user', 'Auth key'),
            'password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('user', 'Password hash'),
            'password_reset_token' => Yii::t('user', 'Password reset token'),
            'email' => Yii::t('app', 'Email'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->username($username)->enabled()->one();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()->email($email)->enabled()->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->getModule('user')->passwordResetTokenExpire;
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::find()->password_reset_token($token)->enabled()->one();
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @return $this
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);

        return $this;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        return $this;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
        return $this;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
        return $this;
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return mixed
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findByPasswordResetToken($token);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return mixed
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->getModule('user')->passwordResetTokenExpire;
        return $timestamp + $expire >= time();
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public static function getUserGroup()
    {
        /** @var User $identity */
        $identity = Yii::$app->getUser()->getIdentity();
        return isset($identity->group->role) ?? false;
    }

    /**
     * Set user role on user group change
     */
    protected function setRole()
    {
        Yii::$app->authManager->revokeAll($this->id);
        $role = Yii::$app->authManager->getRole($this->group->role);
        if ($role !== null) {
            Yii::$app->authManager->assign($role, $this->id);
        }
    }

    /**
     * @param bool $insert
     * @param string|array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->setRole();
        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param int $group_id
     * @return mixed
     */
    public static function getUserIdByGroupId(int $group_id)
    {
        return self::find()->select('id')->group_id($group_id)->column();
    }

    /**
     * @param $role
     * @return array
     */
    public static function getUserIdByRole($role)
    {
        $groups = Group::getIdsByRole($role);

        return (!empty($groups)) ? self::find()->select('id')->group_ids($groups)->column() : [];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogbookAuthModel()
    {
        return $this->hasMany(LogbookAuthModel::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountLogin()
    {
        return self::getLogbookAuthModel()
            ->andFilterWhere(['action' => 'login'])
            ->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastDateLogin()
    {

        $query = LogbookAuthModel::find()
            //->select('created_at')
            ->andFilterWhere(['action' => 'login', 'user_id' => $this->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if ($query) {
            return date('d.m.Y H:i', $query['created_at']);
        } else {
            return false;
        }
    }
}
