<?php

namespace api\modules\user\models;

/**
 * Class User
 *
 * @package api\modules\user\models
 */
class User extends \backend\modules\user\models\User
{
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->where(['auth_key' => $token])
            ->enabled()
            ->one();
    }
}
