<?php

namespace thread\modules\user;

use Yii;
use yii\helpers\Url;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class User
 *
 * @property string $username_attribute
 * @property integer $password_min_length
 * @property boolean $auto_login_after_register
 * @property integer $time_remember_user_sign_in
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class User extends aModule
{
    public $name = 'user';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public $itemOnPage = 100;

    public $username_attribute = 'username';
    public $password_min_length = 4;
    public $auto_login_after_register = true;
    public $time_remember_user_sign_in = 2592000; // 24 * 30 * 3600

    public $passwordResetTokenExpire = 3600;

    /**
     * @return object|string|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }

    /**
     * @return string
     */
    public static function getRedirectUrlAfterLogin()
    {
        return Url::toRoute(['/home/home/index']);
    }

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
        return '/uploads/' . $this->name . '/';
    }
}
