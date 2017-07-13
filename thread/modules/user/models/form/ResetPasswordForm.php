<?php
namespace thread\modules\user\models\form;

use Yii;
use yii\base\InvalidParamException;
//
use thread\modules\user\models\User as UserModel;

/**
 * Password reset form
 */
class ResetPasswordForm extends CommonForm
{
    /**
     * @var UserModel
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = UserModel::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function setPassword()
    {
        $user = $this->_user;
        $user->setScenario('setPassword');
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
