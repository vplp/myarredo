<?php

namespace thread\modules\user\models;

use Yii;
use yii\web\IdentityInterface;
use thread\app\base\models\ActiveRecord;

/**
 * Class UserIdentity
 *
 * @package thread\modules\user\models
 */
class UserIdentity extends ActiveRecord implements IdentityInterface
{
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
}
