<?php

namespace common\modules\user;

/**
 * Class User
 *
 * @package common\modules\user
 */
class User extends \thread\modules\user\User
{
    /**
     * @param $user_id
     * @return string
     */
    public function getAvatarUploadPath($user_id)
    {
        $dir = $this->getBaseUploadPath() . $user_id . '/profile';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * @param $user_id
     * @return string
     */
    public function getAvatarUploadUrl($user_id)
    {
        return $this->getBaseUploadUrl() . $user_id . '/profile';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        return '/uploads/' . $this->name;
    }
}
