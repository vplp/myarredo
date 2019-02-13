<?php

namespace common\modules\user\models\form;

use Yii;
use yii\db\mssql\PDO;
use yii\helpers\ArrayHelper;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\user\models\{
    Group, Profile, User
};
use common\modules\location\models\{
    City, Country
};

/**
 * Class RegisterForm
 *
 * @property City $city
 *
 * @package common\modules\user\models\form
 */
class RegisterForm extends CommonForm
{
    public $reCaptcha;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [
                [
                    'password',
                    'password_confirmation',
                ],
                'required'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone'
                ],
                'required',
                'on' => 'register'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'name_company',
                    'address',
                    'country_id',
                    'city_id',
                    'user_agreement',
                    'reCaptcha'
                ],
                'required',
                'on' => 'registerPartner'
            ],
            [
                [
                    'last_name',
                    'phone',
                    'name_company',
                    'address',
                    'country_id',
                    'city_id',
                    'user_agreement',
                    //'factory_package',
                    'reCaptcha'
                ],
                'required',
                'on' => 'registerFactory'
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'address',
                    'name_company',
                    'website',
                    'exp_with_italian',
                    'cape_index'
                ],
                'string',
                'max' => 255
            ],
            [
                ['user_agreement'],
                'required',
                'on' => ['registerPartner', 'registerFactory'],
                'requiredValue' => 1,
                'message' => Yii::t('app', 'Вы должны ознакомиться и согласиться')
            ],
            [['delivery_to_other_cities', 'user_agreement'], 'in', 'range' => [0, 1]],
            [['country_id', 'city_id'], 'integer'],
            [['country_id', 'city_id', 'delivery_to_other_cities'], 'default', 'value' => 0],
            [
                ['password_confirmation'],
                'compare',
                'compareAttribute' => 'password',
                'on' => [
                    'adminPasswordChange',
                    'register',
                    'registerPartner',
                    'registerFactory'
                ]
            ],
            [['reCaptcha'], \frontend\widgets\recaptcha3\RecaptchaV3Validator::class, 'acceptance_score' => 0.5],
            [
                ['cape_index'],
                'required',
                'on' => 'registerPartner',
                'when' => function ($model) {
                    return $model->country_id === 4;
                },
                'whenClient' => "function (attribute, value) {
                    return $('select[name=\"RegisterForm[country_id]\"]').val() == 4;
                }"
            ],
        ];

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
            'register' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'country_id',
                'city_id',
            ],
            'registerPartner' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'delivery_to_other_cities',
                'user_agreement',
                'reCaptcha',
                'cape_index'
            ],
            'registerFactory' => [
                'username',
                'email',
                'password',
                'password_confirmation',
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'website',
                'country_id',
                'city_id',
                'user_agreement',
                //'factory_package'
                'reCaptcha'
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Add new user to base
     */
    public function addUser()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
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
                    return $this->addUserProfile($model->id);
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
    private function addUserProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'preferred_language' => Yii::$app->language,
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

    /**
     * Add new partner to base
     */
    public function addPartner()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_OFF,
            'group_id' => Group::PARTNER,
        ]);

        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addPartnerProfile($model->id);
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
     * Create new empty profile for a new partner
     *
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    private function addPartnerProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'name_company' => $this->name_company,
            'website' => $this->website,
            'exp_with_italian' => $this->exp_with_italian,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'delivery_to_other_cities' => $this->delivery_to_other_cities,
            'cape_index' => $this->cape_index,
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

    /**
     * Add new Factory to base
     */
    public function addFactory()
    {
        $model = new User([
            'scenario' => 'userCreate',
            'username' => $this->email,
            'email' => $this->email,
            'published' => ActiveRecord::STATUS_KEY_ON,
            'group_id' => Group::FACTORY,
        ]);

        $model->setPassword($this->password)->generateAuthKey();

        if ($model->validate()) {
            /** @var PDO $transaction */
            $transaction = self::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();
                    return $this->addFactoryProfile($model->id);
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
     * Create new empty profile for a new Factory
     *
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    private function addFactoryProfile($userId)
    {
        $model = new Profile([
            'scenario' => 'basicCreate',
            'user_id' => $userId,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'name_company' => $this->name_company,
            'website' => $this->website,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            //'factory_package' => $this->factory_package,
            'preferred_language' => Yii::$app->language,
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
