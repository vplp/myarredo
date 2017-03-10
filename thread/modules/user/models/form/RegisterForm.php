<?php
namespace thread\modules\user\models\form;

use yii\db\mssql\PDO;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\user\models\{
    Group, Profile, User
};
use yii\helpers\ArrayHelper;

/**
 * Class RegisterForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class RegisterForm extends CommonForm
{

    /**
     * @return array
     */
    public function rules()
    {
        $rules =  [[['password', 'password_confirmation'], 'required']];

        if ($this->_username_attribute === 'email') {
            $rules[] = [['email'], 'required'];
        } elseif ($this->_username_attribute === 'username') {
            $rules[] = [['username'], 'required'];
        }

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'register' => ['username', 'email', 'password', 'password_confirmation'],
        ];
    }

    /**
     * Add new user to base
     */
    public function addUser()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->username,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_ON,
            'group_id' => Group::USER,
        ]);
        $model->setPassword($this->password)->generateAuthKey();
        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addProfile($model->id);
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }

    /**
     * Create new empty profile for a new user
     *
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    private function addProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
        ]);
        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                ($save) ? $transaction->commit() : $transaction->rollBack();
                return $save;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        } else {
            $this->addErrors($model->getErrors());
            return false;
        }
    }
}
