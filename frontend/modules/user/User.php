<?php

namespace frontend\modules\user;
use yii\helpers\Url;

/**
 * Class User
 *
 * @package frontend\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class User extends \common\modules\user\User
{
    /**
     * @return string
     */
    public function getUrlLogin()
    {
        return Url::to(['/user/login']);
    }

    /**
     * @return string
     */
    public function getUrlLogOut()
    {
        return Url::to(['/user/logout']);
    }

    /**
     * @return string
     */
    public function getUrlPasswordChange()
    {
        return Url::to(['/user/profile/password-change']);
    }

    /**
     * @return string
     */
    public function getUrlRegistration()
    {
        return Url::to(['/user/register']);
    }

    /**
     * @return string
     */
    public function getUrlProfile()
    {
        return Url::to(['/user/profile/index']);
    }

    /**
     * @return string
     */
    public function getUrlUpdateProfile()
    {
        return Url::to(['/user/profile/update']);
    }

    /**
     * @return string
     */
    public function getUrlRequestResetPassword()
    {
        return Url::to(['/user/profile/request-password-reset']);
    }

}
